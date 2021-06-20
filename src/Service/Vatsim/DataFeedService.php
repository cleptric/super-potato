<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use App\Model\Entity\Airport;
use App\Model\Entity\User;
use App\Service\AirportsService;
use App\Service\LogsService;
use App\Traits\ZMQContextTrait;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;
use Cake\I18n\FrozenTime;
use Throwable;
use function Sentry\captureMessage;

class DataFeedService
{

    use ModelAwareTrait;
    use ZMQContextTrait;

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
     * @var int
     */
    protected int $_retries = 0;

    /**
     * @var \Cake\Http\Client
     */
    protected Client $_client;

    const FEED_MAX_AGE = '5 minutes ago';

    const MAX_RETRIES = 10;

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

        $this->_client = new Client();
    }

    public function getFeed()
    {
        try {
            $this->_fetchFeed();
            $this->_persistFeed();
        } catch (Throwable $t) {
            $this->_retries = $this->_retries + 1;
            if ($this->_retries >= self::MAX_RETRIES) {
                captureMessage('Could not fetch VATSIM data feed after 10 tries');
                $this->_retries = 0;
            }
        }
    }

    protected function _fetchFeed(): void
    {
        $feedUrl = $this->_getFeedUrl();
        $response = $this->_client->get($feedUrl);

        $this->_rawFeed = $response->getStringBody();
    }

    protected function _persistFeed(): void
    {
        if (empty($this->_rawFeed)) {
            return;
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

                $this->pushMessage('refresh');
            } else if (!empty($lastFeed) && $lastFeed->created <= new FrozenTime(self::FEED_MAX_AGE)) {
                // Delete an outdated feed
                $this->Feeds->delete($lastFeed);

                $this->pushMessage('refresh');
            }

            // Nobody is online any more, reset airports state and delete all logs
            if (empty($data['controllers'])) {
                (new AirportsService())->resetState();
                (new LogsService())->deleteAllLogs();

                $this->pushMessage('refresh');
            }
        }
    }

    protected function _getFeedUrl(): ?string
    {
        $client = new Client();
        $response = $this->_client->get($this->_vatsimStatusUrl);
        $responseBody = json_decode($response->getStringBody(), true);

        return $responseBody['data'][$this->_vatsimFeedVersion][0];
    }
}