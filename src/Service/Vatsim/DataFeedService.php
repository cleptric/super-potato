<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;
use Cake\I18n\FrozenTime;
use Exception;

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

    protected array $_atisStations = [
        'LOWW_ATIS',
        'LOWI_ATIS',
        'LOWS_ATIS',
        'LOWG_ATIS',
        'LOWK_ATIS',
        'LOWL_ATIS',
    ];

    public function __construct()
    {
        $this->loadModel('Feeds');
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

        // Only store the latest feed if we do not have in the DB yet
        if (empty($lastFeed) || $lastFeed->created < $feedUpdatedAt) {
            $data = [];
            foreach ($parsedFeed['atis'] as $atis) {
                if (in_array($atis['callsign'], $this->_atisStations)) {
                    $data[$atis['callsign']] = trim(join(' ', $atis['text_atis']));
                }
            }

            if (!empty($data)) {
                $feedEntity = $this->Feeds->newEntity([
                    'data' => $data,
                ]);
                $savedFeed = $this->Feeds->save($feedEntity);
                $this->Feeds->deleteAll(['id IS NOT' => $savedFeed->id]);
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