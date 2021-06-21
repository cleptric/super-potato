<?php
declare(strict_types=1);

namespace App\Service\CheckWx;

use App\Model\Entity\Airport;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;

class TafService
{
    use ModelAwareTrait;
    use ZMQContextTrait;

    /**
     * @var string
     */
    protected string $_checkWxApiUrl = 'https://api.checkwx.com/taf/';

    /**
     * @var string
     */
    protected ?string $_rawTaf = null;

    /**
     * @var \Cake\Http\Client
     */
    protected Client $_client;

    /**
     * @var array
     */
    protected array $_tafStations = [
        Airport::LOWW_ICAO,
        Airport::LOWI_ICAO,
        Airport::LOWS_ICAO,
        Airport::LOWG_ICAO,
        Airport::LOWK_ICAO,
        Airport::LOWL_ICAO,
    ];

    public function __construct()
    {
        $this->loadModel('Taf');

        $this->_client = new Client();
    }

    public function getTaf(): void
    {
        $this->_fetchTaf();
        $this->_persistTaf();
    }

    protected function _fetchTaf(): void
    {
        $response = $this->_client->get($this->_checkWxApiUrl . implode(',', $this->_tafStations) . '/decoded', [], [
            'headers' => [
                'X-API-Key' => env('CHECK_WX_API_TOKEN'),
            ],
        ]);
        $this->_rawTaf = $response->getStringBody();
    }

    protected function _persistTaf(): void
    {
        if (empty($this->_rawTaf)) {
            return;
        }

        $data = [];
        $rawTaf = json_decode($this->_rawTaf, true);
        foreach ($rawTaf['data'] as $taf) {
            $data[$taf['icao']] = $taf;
        }

        $metarEntity = $this->Taf->newEntity([
            'data' => $data,
        ]);
        $savedTaf = $this->Taf->save($metarEntity);
        $this->Taf->deleteAll(['id IS NOT' => $savedTaf->id]);

        $this->pushMessage('refresh');
    }
}
