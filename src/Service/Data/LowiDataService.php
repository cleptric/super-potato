<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\Atis\LowiDecoderService;
use App\Service\WindComponent\LowiWindComponentService;

class LowiDataService extends AbstractDataService
{
    protected string $_airportIcao = Airport::LOWI_ICAO;

    protected array $_airportRunways = [
        '08/26',
    ];

    protected array $_visualDepatureDirections = [
        'south',
    ];

    protected string $_atisDecoderService = LowiDecoderService::class;

    protected string $_windComponentService = LowiWindComponentService::class;
}
