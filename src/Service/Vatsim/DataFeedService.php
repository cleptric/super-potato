<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use App\Model\Entity\Airport;
use App\Model\Entity\User;
use App\Service\AirportsService;
use App\Service\LogsService;
use App\Service\Atis\AtisDecoderService;
use App\Traits\ZMQContextTrait;
use Cake\Console\ConsoleIo;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;
use Cake\I18n\FrozenTime;

class DataFeedService
{
    use ModelAwareTrait;
    use ZMQContextTrait;

    /**
     * @var string
     */
    protected const _VATSIM_STATUS_URL = 'https://status.vatsim.net/status.json';

    /**
     * @var \Cake\Console\ConsoleIo|null
     */
    protected ?ConsoleIo $_io;

    /**
     * @var string
     */
    protected string $_vatsimFeedVersion = 'v3';

    /**
     * @var \Cake\Http\Client
     */
    protected Client $_client;

    /**
     * @var \App\Service\AirportsService
     */
    protected AirportsService $_airportService;

    /**
     * @var \App\Service\LogsService
     */
    protected LogsService $_logsService;

    /**
     * @var \App\Service\Atis\AtisDecoderService
     */
    protected AtisDecoderService $_atisDecoderService;

    /**
     * @var string|null
     */
    protected ?string $_feedUrl;

    public function __construct()
    {
        $this->loadModel('Airports');
        $this->loadModel('Atis');
        $this->loadModel('Controllers');
        $this->loadModel('Feeds');

        $this->_client = new Client();
        $this->_airportService = new AirportsService();
        $this->_logsService = new LogsService();
        $this->_atisDecoderService = new AtisDecoderService();

        $this->_feedUrl = $this->_getFeedUrl();
    }

    public function getFeed()
    {
        $rawFeed = $this->_fetchFeed();

        $airports = $this->Airports->find()
            ->all();

        $controllers = $this->Controllers->find()
            ->all();

        $rawFeed['atis'][] = [
            'callsign' => 'LOWW_ATIS',
            'atis_code' => 'G',
            'text_atis' => [
                'TRANSITION LEVEL 70',
                'DEPARTURE RUNWAY 11 ARRIVAL RUNWAY 11 YOO',
            ],
        ];

        foreach ($airports as $airport) {
            // Store ATIS
            foreach ($rawFeed['atis'] as $rawAtis) {
                if (!empty($rawAtis['text_atis']) && $rawAtis['callsign'] === $airport->atis_callsign) {
                    $textAtis = trim(join(' ', $rawAtis['text_atis']));

                    $this->_atisDecoderService->setAtis($textAtis);
                    $this->_atisDecoderService->setAirport($airport);

                    $decodedAtis = $this->_atisDecoderService->getData($textAtis);

                    $atis = $this->Atis->newEntity([
                        'airport_id' => $airport->id,
                        'raw_atis' => $textAtis,
                        'atis_letter' => $rawAtis['atis_code'],
                        'depature_runway' => $decodedAtis['depature_runway'],
                        'arrival_runway' => $decodedAtis['arrival_runway'],
                        'transition_level' => $decodedAtis['transition_level'],
                    ]);
                    $savedAtis = $this->Atis->save($atis);
                    $this->Atis->deleteAll([
                        'id IS NOT' => $savedAtis->id,
                        'airport_id' => $savedAtis->airport_id,
                    ]);

                    // Cleanup
                }
            }
        }

        // foreach ($parsedFeed['controllers'] as $controller) {
        //     // Only store Austrian controllers
        //     if (in_array(substr($controller['callsign'], 0, 4), User::CONTROLER_PREFIX)) {
        //         $data['controllers'][] = [
        //             'vatsim_id' => $controller['cid'],
        //             'callsign' => $controller['callsign'],
        //             'facility' => $controller['facility'],
        //         ];
        //     }
        // }
        //
        // if (!empty($data)) {
        //     $feedEntity = $this->Feeds->newEntity([
        //         'data' => $data,
        //     ]);
        //     $savedFeed = $this->Feeds->save($feedEntity);
        //     $this->Feeds->deleteAll(['id IS NOT' => $savedFeed->id]);
        //
        //     $this->pushMessage('refresh');
        // } elseif (!empty($lastFeed) && $lastFeed->created <= new FrozenTime(self::FEED_MAX_AGE)) {
        //     // Delete an outdated feed
        //     $this->Feeds->delete($lastFeed);
        //
        //     $this->pushMessage('refresh');
        // }
        //
        // // Nobody is online any more, reset airports state and delete all logs
        // if (empty($data['controllers'])) {
        //     if ($this->_airportService->isResetState() === false) {
        //         $this->_airportService->resetState();
        //         $this->pushMessage('refresh');
        //     }
        //     if ($this->_logsService->logsEmpty() === false) {
        //         $this->_logsService->deleteAllLogs();
        //         $this->pushMessage('refresh');
        //     }
        // }
    }

    public function setIo(ConsoleIo $io)
    {
        $this->_io = $io;
    }

    protected function _fetchFeed(): array
    {
        $response = $this->_client->get($this->_feedUrl);
        if ($response->isOk()) {
            return $response->getJson();
        }

        return [];
    }

    protected function _getFeedUrl(): ?string
    {
        $response = $this->_client->get(self::_VATSIM_STATUS_URL);
        if ($response->isOk()) {
            $responseBody = $response->getJson();

            return $responseBody['data'][$this->_vatsimFeedVersion][0];
        }

        return null;
    }
}
