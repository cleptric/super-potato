<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\Atis\LowwDecoderService;
use App\Service\Metar\MetarDecoderService;
use App\Service\WindComponent\LowwWindComponentService;
use Authentication\Identity;
use Cake\Datasource\ModelAwareTrait;

class LowwDataService
{
    use ModelAwareTrait;

    protected ?Airport $_airport;

    protected ?array $_feed;

    protected ?array $_metar;

    public function __construct(array $feed, array $metar)
    {
        $this->loadModel('Airports');

        $this->_airport = $this->Airports->find()
            ->where(['name' => 'loww'])
            ->first();

        $this->_feed = $feed;
        $this->_metar = $metar;
    }

    public function getData(): array
    {
        $atisService = new LowwDecoderService();
        $atisService->setDataFeed($this->_feed);
        $atis = $atisService->getData();

        $metarDecoderService = new MetarDecoderService();
        $metarDecoderService->setMetar($this->_metar['data']['LOWW']);
        $metar = $metarDecoderService->getData();

        $windComponentService = new LowwWindComponentService();
        $windComponentService->setMeanDirection($metar['mean_direction']);
        $windComponentService->setMeanSpeed($metar['mean_speed']);
        $windComponents = $windComponentService->getData();

        return [
            'atis' => $atis,
            'metar' => $metar,
            'wind_components' => $windComponents,
            'missed_approach' => $this->_airport->missed_approach,
            'missed_approach_timeout' => $this->_airport->missed_approach_timeout->toUnixString(),
            'closed_runways' => $this->_airport->closed_runways ?? [],
            'closed_runways_timeout' => $this->_airport->closed_runways_timeout->toUnixString(),
            'visual_depature' => $this->_airport->visual_depatures ?? [],
        ];
    }
}