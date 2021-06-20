<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use App\Model\Entity\Airport;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;
use Throwable;
use ZMQ;
use ZMQContext;
use function Sentry\captureMessage;

class MetarService
{
    use ModelAwareTrait;

    /**
     * @var string
     */
    protected string $_vatsimStatusUrl = 'https://status.vatsim.net/status.json';

    /**
     * @var array
     */
    protected ?array $_rawMetar = null;

    /**
     * @var int
     */
    protected int $_retries = 0;

    /**
     * @var \Cake\Http\Client
     */
    protected Client $_client;

    public const MAX_RETRIES = 5;

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
        try {
            $this->_fetchMetar();
            $this->_persistMetar();
        } catch (Throwable $t) {
            $this->_retries = $this->_retries + 1;
            if ($this->_retries >= self::MAX_RETRIES) {
                captureMessage('Could not fetch VATSIM METAR after 5 tries');
                $this->_retries = 0;
            }
        }
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

        $currentMetar = $this->Metar->find()
            ->order(['created' => 'DESC'])
            ->first();

        $metarEntity = $this->Metar->newEntity([
            'data' => $this->_rawMetar,
        ]);
        $savedMetar = $this->Metar->save($metarEntity);
        $this->Metar->deleteAll(['id IS NOT' => $savedMetar->id]);

        $context = new ZMQContext();
        $socket = $context->getSocket(ZMQ::SOCKET_PUSH);
        $socket->connect('tcp://localhost:5555');
        $socket->send(json_encode(['type' => 'refresh']));
    }

    protected function _getMetarUrl(): ?string
    {
        $response = $this->_client->get($this->_vatsimStatusUrl);
        $responseBody = json_decode($response->getStringBody(), true);

        return $responseBody['metar'][0];
    }
}
