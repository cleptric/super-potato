<?php
declare(strict_types=1);

namespace App\Service\CheckWx;

use App\Traits\ZMQContextTrait;
use Cake\Console\ConsoleIo;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;

/**
 * @property \App\Model\Table\AirportsTable $Airports
 * @property \App\Model\Table\TafTable $Taf
 */
class TafService
{
    use ModelAwareTrait;
    use ZMQContextTrait;

    /**
     * @var string
     */
    protected const _CHECK_WX_URL = 'https://api.checkwx.com/taf/';

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

        foreach ($rawTaf['data'] as $taf) {
            $data[$taf['icao']] = $taf;
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
        $response = $this->_client->get(self::_CHECK_WX_URL . implode(',', $tafStations) . '/decoded', [], [
            'headers' => [
                'X-API-Key' => env('CHECK_WX_API_TOKEN'),
            ],
        ]);
        if ($response->isOk()) {
            return $response->getJson();
        }

        return [];
    }
}
