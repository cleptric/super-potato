<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\Atis\LowlDecoderService;
use App\Service\WindComponent\LowlWindComponentService;

class LowlDataService extends AbstractDataService
{
    protected string $_airportIcao = Airport::LOWL_ICAO;

    protected array $_airportRunways = [
        '08/26',
    ];

    protected array $_visualDepatureDirections = [];

    protected string $_atisDecoderService = LowlDecoderService::class;

    protected string $_windComponentService = LowlWindComponentService::class;
}
