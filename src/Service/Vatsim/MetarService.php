<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use App\Model\Entity\Airport;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;
use Exception;
use ZMQContext;
use ZMQ;

class MetarService
{

    use ModelAwareTrait;

    /**
     * @var string
     */
    protected string $_vatsimStatusUrl = 'https://status.vatsim.net/status.json';

    /**
     * @var string
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

    public function fetchMetar(): void
    {
        $metarUrl = $this->_getMetarUrl();
        $metar = [];

        foreach ($this->_metarStations as $station) {
            $response = $this->_client->get($metarUrl, [
                'id' => $station,
            ]);
            $this->_rawMetar[$station] = $response->getStringBody();
        }
    }

    public function persistMetar(): void
    {
        if (empty($this->_rawMetar)) {
            throw new Exception('METAR is empty. Did you fetch it first?');
        }

        $metarEntity = $this->Metar->newEntity([
            'data' => $this->_rawMetar,
        ]);
        $savedMetar = $this->Metar->save($metarEntity);
        $this->Metar->deleteAll(['id IS NOT' => $savedMetar->id]);

        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
        $socket->connect("tcp://localhost:5555");
        $socket->send(json_encode(['type' => 'refresh']));
    }

    protected function _getMetarUrl():string
    {
        $response = $this->_client->get($this->_vatsimStatusUrl);
        $responseBody = json_decode($response->getStringBody(), true);

        return $responseBody['metar'][0];
    }
}