<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\Atis\LowiDecoderService;
use App\Service\WindComponent\LowiWindComponentService;

class LowiDataService extends AbstractDataService
{
    protected string $_airportIcao = Airport::LOWI_ICAO;

    protected string $_atisDecoderService = LowiDecoderService::class;

    protected string $_windComponentService = LowiWindComponentService::class;
}