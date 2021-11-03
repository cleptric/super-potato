<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use App\Model\Entity\Airport;
use App\Traits\ZMQContextTrait;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;

class MetarService
{
    use ModelAwareTrait;
    use ZMQContextTrait;

    /**
     * @var string
     */
    protected string $_vatsimStatusUrl = 'https://status.vatsim.net/status.json';

    /**
     * @var array|null
     */
    protected ?array $_rawMetar = null;

    /**
     * @var \Cake\Http\Client
     */
    protected Client $_client;

    /**
     * @var array
     */
    protected array $_metarStations = [
        Airport::LOWW_ICAO,
        Airport::LOWI_ICAO,
        Airport::LOWS_ICAO,
        Airport::LOWG_ICAO,
        Airport::LOWK_ICAO,
        Airport::LOWL_ICAO,
    ];

    public function __construct()
    {
        $this->loadModel('Metar');

        $this->_client = new Client();
    }

    public function getMetar(): void
    {
        $this->_fetchMetar();
        $this->_persistMetar();
    }

    protected function _fetchMetar(): void
    {
        $metarUrl = $this->_getMetarUrl();
        $this->_rawMetar = [];

        foreach ($this->_metarStations as $station) {
            $response = $this->_client->get($metarUrl, [
                'id' => $station,
            ]);
            $this->_rawMetar[$station] = $response->getStringBody();
        }
    }

    protected function _persistMetar(): void
    {
        if (empty($this->_rawMetar)) {
            return;
        }

        $metarEntity = $this->Metar->newEntity([
            'data' => $this->_rawMetar,
        ]);
        $savedMetar = $this->Metar->save($metarEntity);
        $this->Metar->deleteAll(['id IS NOT' => $savedMetar->id]);

        $this->pushMessage('refresh');
    }

    protected function _getMetarUrl(): ?string
    {
        $response = $this->_client->get($this->_vatsimStatusUrl);
        $responseBody = json_decode($response->getStringBody(), true);

        return $responseBody['metar'][0];
    }
}
