<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\Metar\MetarDecoderService;
use Cake\Datasource\ModelAwareTrait;

abstract class AbstractDataService
{
    use ModelAwareTrait;

    protected ?Airport $_airport;

    protected ?array $_feed = null;

    protected ?array $_metar = null;

    protected ?array $_taf = null;

    public function __construct(?array $feed, ?array $metar, ?array $taf)
    {
        $this->loadModel('Airports');

        $this->_airport = $this->Airports->find()
            ->where(['name' => $this->_airportIcao])
            ->first();

        $this->_feed = $feed;
        $this->_metar = $metar;
        $this->_taf = $taf;
    }

    public function getData(): array
    {
        $atisService = new $this->_atisDecoderService();
        $atisService->setDataFeed($this->_feed);
        $atis = $atisService->getData();

        $metarDecoderService = new MetarDecoderService();
        $metarDecoderService->setMetar($this->_metar['data'][strtoupper($this->_airportIcao)] ?? null);
        $metar = $metarDecoderService->getData();

        $taf = $this->_taf['data'][strtoupper($this->_airportIcao)]['raw_text'];

        $windComponentService = new $this->_windComponentService();
        $windComponentService->setMeanDirection($metar['mean_direction']);
        $windComponentService->setMeanSpeed($metar['mean_speed']);
        $windComponents = $windComponentService->getData();

        return [
            'icao' => $this->_airportIcao,
            'runways' => $this->_airportRunways,
            'atis' => $atis,
            'metar' => $metar,
            'taf' => $taf,
            'wind_components' => $windComponents,
            'missed_approach' => $this->_airport->missed_approach,
            'missed_approach_timeout' => $this->_airport->missed_approach_timeout->toUnixString(),
            'closed_runways' => $this->_airport->closed_runways ?? [],
            'closed_runways_timeout' => $this->_airport->closed_runways_timeout->toUnixString(),
            'visual_depature' => $this->_airport->visual_depatures ?? [],
            'visual_depature_directions' => $this->_visualDepatureDirections,
            'notification' => $this->_hasNotification(),
        ];
    }

    protected function _hasNotification(): bool
    {
        return $this->_airport->missed_approach || !empty($this->_airport->closed_runways);
    }
}
