<?php
declare(strict_types=1);

namespace App\Service\CheckWx;

use App\Traits\ZMQContextTrait;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;

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
     * @var string
     */
    protected ?string $_rawTaf = null;

    /**
     * @var \Cake\Http\Client
     */
    protected Client $_client;

    public function __construct()
    {
        $this->loadModel('Airports');
        $this->loadModel('Taf');

        $this->_client = new Client();
    }

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

    public function setIo(ConsoleIo $io)
    {
        $this->_io = $io;
    }

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
