<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\Atis\LowwDecoderService;
use App\Service\WindComponent\LowwWindComponentService;

class LowwDataService extends AbstractDataService
{
    protected string $_airportIcao = Airport::LOWW_ICAO;

    protected string $_atisDecoderService = LowwDecoderService::class;

    protected string $_windComponentService = LowwWindComponentService::class;
}