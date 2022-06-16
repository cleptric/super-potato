<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use App\Enums\QnhTrend;
use App\Service\Metar\MetarDecoderService;
use App\Traits\ZMQContextTrait;
use Cake\Console\ConsoleIo;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;

class MetarService
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
     * @var \Cake\Http\Client
     */
    protected Client $_client;

    /**
     * @var \App\Service\Metar\MetarDecoderService
     */
    protected MetarDecoderService $_metarDecoder;

    /**
     * @var string|null
     */
    protected ?string $_metarUrl;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->loadModel('Airports');
        $this->loadModel('Metar');

        $this->_client = new Client();
        $this->_metarDecoder = new MetarDecoderService();
        $this->_metarUrl = $this->_getMetarUrl();
    }

    /**
     * @return void
     */
    public function getMetar(): void
    {
        $airports = $this->Airports->find()
            ->all();

        foreach ($airports as $airport) {
            $rawMetar = $this->_fetchMetar($airport->icao);

            $this->_metarDecoder->setMetar($rawMetar);
            $decodedMetar = $this->_metarDecoder->getData();

            $previousMetar = $this->Metar->find()
                ->where(['airport_id' => $airport->id])
                ->order(['created' => 'DESC'])
                ->first();

            $metarEntity = $this->Metar->newEntity([
                'airport_id' => $airport->id,
                'qnh_value' => $decodedMetar['qnh_value'],
                'qnh_unit' => $decodedMetar['qnh_unit'],
                'qnh_trend' => $this->_getQnhTrend($decodedMetar['qnh_value'], $previousMetar->qnh ?? null)->value ?? null,
                'temperature' => $decodedMetar['temperature'],
                'dew_point' => $decodedMetar['dew_point'],
                'mean_direction' => $decodedMetar['mean_direction'],
                'is_variable' => $decodedMetar['is_variable'],
                'mean_speed' => $decodedMetar['mean_speed'],
                'speed_variations' => $decodedMetar['speed_variations'],
                'wind_shear_runways' => $decodedMetar['wind_shear_runways'],
                'wind_shear_all_runways' => $decodedMetar['wind_shear_all_runways'],
                'raw_metar' => $decodedMetar['raw_metar'],
                'rvr' => $decodedMetar['rvr'],
                'conditions' => $decodedMetar['conditions'],
            ]);
            $savedMetar = $this->Metar->save($metarEntity);
            $this->Metar->deleteAll([
                'id IS NOT' => $savedMetar->id,
                'airport_id' => $savedMetar->airport_id,
            ]);
        }
    }

    /**
     * @param \Cake\Console\ConsoleIo $io IO
     * @return void
     */
    public function setIo(ConsoleIo $io)
    {
        $this->_io = $io;
    }

    /**
     * @param string $station Station
     * @return string|null
     */
    protected function _fetchMetar(string $station): ?string
    {
        $response = $this->_client->get($this->_metarUrl, [
            'id' => $station,
        ]);
        if ($response->isOk()) {
            return $response->getStringBody();
        }

        return null;
    }

    /**
     * @return string|null
     */
    protected function _getMetarUrl(): ?string
    {
        $response = $this->_client->get(self::_VATSIM_STATUS_URL);
        if ($response->isOk()) {
            $responseBody = $response->getJson();

            return $responseBody['metar'][0];
        }

        return null;
    }

    /**
     * @param int|null $currentQnh Current QNH
     * @param int|null $previousQnh Previous QNH
     * @return \App\Enums\QnhTrend
     */
    protected function _getQnhTrend(?int $currentQnh, ?int $previousQnh): ?QnhTrend
    {
        if (isset($currentMetar) && isset($previousQnh)) {
            if ($currentMetar > $previousQnh) {
                return QnhTrend::UP;
            }
            if ($currentMetar < $previousQnh) {
                return QnhTrend::DOWN;
            }
        }

        return null;
    }
}
