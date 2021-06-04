<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\Atis\LowkDecoderService;
use App\Service\WindComponent\LowkWindComponentService;

class LowkDataService extends AbstractDataService
{
    protected string $_airportIcao = Airport::LOWK_ICAO;

    protected array $_airportRunways = [
        '10L/28R',
    ];

    protected array $_visualDepatureDirections = [];

    protected string $_atisDecoderService = LowkDecoderService::class;

    protected string $_windComponentService = LowkWindComponentService::class;
}