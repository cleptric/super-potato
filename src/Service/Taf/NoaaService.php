<?php
declare(strict_types=1);

namespace App\Service\Taf;

use App\Traits\ZMQContextTrait;
use Cake\Console\ConsoleIo;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;

/**
 * @property \App\Model\Table\AirportsTable $Airports
 * @property \App\Model\Table\TafTable $Taf
 */
class NoaaService
{
    use ModelAwareTrait;
    use ZMQContextTrait;

    /**
     * @var string
     */
    protected const _NOAA_URL = 'https://aviationweather.gov/adds/dataserver_current/httpparam?dataSource=tafs&requestType=retrieve&format=xml&mostRecentForEachStation=true&hoursBeforeNow=0&stationString=';

    /**
     * @var \Cake\Console\ConsoleIo|null
     */
    protected ?ConsoleIo $_io;

    /**
     * @var string|null
     */
    protected ?string $_rawTaf = null;

    /**
     * @var \Cake\Http\Client
     */
    protected Client $_client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->loadModel('Airports');
        $this->loadModel('Taf');

        $this->_client = new Client();
    }

    /**
     * @return void
     */
    public function getTaf(): void
    {
        $airports = $this->Airports->find()
            ->select(['icao'])
            ->enableHydration(false)
            ->all()
            ->extract('icao')
            ->toArray();

        $rawTaf = $this->_fetchTaf($airports);

        if ($rawTaf['data']['@attributes']['num_results'] > 1) {
            foreach ($rawTaf['data']['TAF'] as $taf) {
                $data[$taf['station_id']] = $taf['raw_text'];
            }
        } else {
            $data[$rawTaf['data']['TAF']['station_id']] = $rawTaf['data']['TAF']['raw_text'];
        }

        $tafEntity = $this->Taf->newEntity([
            'data' => $data,
        ]);
        $savedTaf = $this->Taf->save($tafEntity);
        $this->Taf->deleteAll(['id IS NOT' => $savedTaf->id]);

        $this->pushMessage('refresh');
    }

    /**
     * @param \Cake\Console\ConsoleIo $io IO
     * @return void
     */
    public function setIo(ConsoleIo $io): void
    {
        $this->_io = $io;
    }

    /**
     * @param array $tafStations TAF stations
     * @return array
     */
    protected function _fetchTaf(array $tafStations): array
    {
        $response = $this->_client->get(self::_NOAA_URL . implode('%20', $tafStations), [], [
            'headers' => [
            ],
        ]);
        if ($response->isOk()) {
            $xmlTaf = $response->getXml();

            return json_decode(json_encode($xmlTaf), true);
        }

        return [];
    }
}
