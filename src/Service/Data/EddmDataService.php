<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\Atis\EddmDecoderService;
use App\Service\WindComponent\EddmWindComponentService;

class EddmDataService extends AbstractDataService
{
    protected string $_airportIcao = Airport::EDDM_ICAO;

    protected array $_airportRunways = [
        '08L/26R',
        '08R/26L',
    ];

    protected array $_visualDepatureDirections = [];

    protected string $_atisDecoderService = EddmDecoderService::class;

    protected string $_windComponentService = EddmWindComponentService::class;
}
