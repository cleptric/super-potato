<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\Atis\LowsDecoderService;
use App\Service\WindComponent\LowsWindComponentService;

class LowsDataService extends AbstractDataService
{
    protected string $_airportIcao = Airport::LOWS_ICAO;

    protected array $_airportRunways = [
        '15/33',
    ];

    protected array $_visualDepatureDirections = [];

    protected string $_atisDecoderService = LowsDecoderService::class;

    protected string $_windComponentService = LowsWindComponentService::class;
}
