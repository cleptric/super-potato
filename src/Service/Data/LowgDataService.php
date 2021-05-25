<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\Atis\LowgDecoderService;
use App\Service\WindComponent\LowgWindComponentService;

class LowgDataService extends AbstractDataService
{
    protected string $_airportIcao = Airport::LOWG_ICAO;

    protected string $_atisDecoderService = LowgDecoderService::class;

    protected string $_windComponentService = LowgWindComponentService::class;
}