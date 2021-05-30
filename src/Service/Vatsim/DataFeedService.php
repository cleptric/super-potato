<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use App\Model\Entity\Airport;
use App\Model\Entity\User;
use App\Service\AirportsService;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;
use Cake\I18n\FrozenTime;
use Exception;
use ZMQContext;
use ZMQ;

class DataFeedService
{

    use ModelAwareTrait;

    /**
     * @var string
     */
    protected string $_vatsimStatusUrl = 'https://status.vatsim.net/status.json';

    /**
     * @var string
     */
    protected ?string $_rawFeed = null;

    /**
     * @var string
     */
    protected string $_vatsimFeedVersion = 'v3';

    /**
     * @var array
     */
    protected array $_atisStations = [
        Airport::LOWW_ATIS_CALLSIGN,
        Airport::LOWI_ATIS_CALLSIGN,
        Airport::LOWS_ATIS_CALLSIGN,
        Airport::LOWG_ATIS_CALLSIGN,
        Airport::LOWK_ATIS_CALLSIGN,
        Airport::LOWL_ATIS_CALLSIGN,
        Airport::LOXZ_ATIS_CALLSIGN,
    ];

    public function __construct()
    {
        $this->loadModel('Feeds');
        $this->loadModel('Airports');
    }

    public function fetchFeed(): void
    {
        $feedUrl = $this->_getFeedUrl();

        $client = new Client();
        $response = $client->get($feedUrl);

        $this->_rawFeed = $response->getStringBody();
    }

    public function persistFeed(): void
    {
        if (empty($this->_rawFeed)) {
            throw new Exception('Feed is empty. Did you fetch it first?');
        }

        $lastFeed = $this->Feeds->find()
            ->order(['created' => 'DESC'])
            ->first();

        $parsedFeed = json_decode($this->_rawFeed, true);
        $feedUpdatedAt = FrozenTime::parse($parsedFeed['general']['update_timestamp']);

        // Only store the latest feed if we do not have it in the DB yet
        if (empty($lastFeed) || $lastFeed->created < $feedUpdatedAt) {
            $data = [];
            foreach ($parsedFeed['atis'] as $atis) {
                if (!empty($atis['text_atis']) && in_array($atis['callsign'], $this->_atisStations)) {
                    $data['atis'][$atis['callsign']]['last_updated'] = $atis['last_updated'];
                    $data['atis'][$atis['callsign']]['raw'] = trim(join(' ', $atis['text_atis']));
                }
            }
            foreach ($parsedFeed['controllers'] as $controller) {
                // Only store Austrian controllers
                if (in_array(substr($controller['callsign'], 0, 4), User::CONTROLER_PREFIX)) {
                    $data['controllers'][] = [
                        'vatsim_id' => $controller['cid'],
                        'callsign' => $controller['callsign'],
                        'facility' => $controller['facility'],
                    ];
                }
            }

            if (!empty($data)) {
                $feedEntity = $this->Feeds->newEntity([
                    'data' => $data,
                ]);
                $savedFeed = $this->Feeds->save($feedEntity);
                $this->Feeds->deleteAll(['id IS NOT' => $savedFeed->id]);

                $context = new ZMQContext();
                $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
                $socket->connect("tcp://localhost:5555");
                $socket->send(json_encode(['type' => 'refresh']));
            }


            // Nobody is online any more, reset airports state
            if (empty($data['controllers'])) {
                (new AirportsService())->resetState();
            }
        }
    }

    protected function _getFeedUrl(): string
    {
        $client = new Client();
        $response = $client->get($this->_vatsimStatusUrl);
        $responseBody = json_decode($response->getStringBody(), true);

        return $responseBody['data'][$this->_vatsimFeedVersion][0];
    }
}