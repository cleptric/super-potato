<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\Atis\EetnDecoderService;
use App\Service\WindComponent\EetnWindComponentService;

class EetnDataService extends AbstractDataService
{
    protected string $_airportIcao = Airport::EETN_ICAO;

    protected array $_airportRunways = [
        '08/26',
    ];

    protected array $_visualDepatureDirections = [];

    protected string $_atisDecoderService = EetnDecoderService::class;

    protected string $_windComponentService = EetnWindComponentService::class;
}
