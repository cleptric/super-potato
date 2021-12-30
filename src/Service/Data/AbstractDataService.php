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

    public function __construct()
    {
        $this->loadModel('Airports');
        $this->loadModel('Taf');

        $this->_airport = $this->Airports->find()
            ->where(['icao' => 'LOWW'])
            ->first();
    }

    public function getData(): array
    {
        $taf = $this->Taf->find()
            ->order(['created' => 'DESC'])
            ->first();

        $atisDataService = new AtisDataService();
        $atisDataService->setAirport($this->_airport);
        $atis = $atisDataService->getData();

        $metarDataService = new MetarDataService();
        $metarDataService->setAirport($this->_airport);
        $metar = $metarDataService->getData();

        $tafDataService = new TafDataService();
        $tafDataService->setAirport($this->_airport);
        $taf = $tafDataService->getData();

        $windComponentService = new $this->_windComponentService();
        $windComponentService->setMeanDirection($metar['mean_direction']);
        $windComponentService->setMeanSpeed($metar['mean_speed']);
        $windComponents = $windComponentService->getData();

        return [
            'name' => sprintf('%s (%s)', $this->_airport->name, $this->_airport->icao),
            'icao' => $this->_airport->icao,
            'runways' => $this->_airportRunways,
            'atis' => $atis,
            'metar' => $metar,
            'taf' => $taf,
            'wind_components' => $windComponents,
            'missed_approach' => $this->_airport->missed_approach,
            'missed_approach_timeout' => $this->_airport->missed_approach_timeout->toUnixString(),
            'closed_runways' => $this->_airport->closed_runways ?? [],
            'closed_runways_timeout' => $this->_airport->closed_runways_timeout->toUnixString(),
            'notification' => $this->_hasNotification(),
        ];
    }

    protected function _hasNotification(): bool
    {
        return $this->_airport->missed_approach || !empty($this->_airport->closed_runways);
    }
}
