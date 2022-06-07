<?php
declare(strict_types=1);

namespace App\Service\Data;

use App\Model\Entity\Airport;
use App\Service\WindComponent\LowwWindComponentService;

class LowwDataService extends AbstractDataService
{
    protected string $_airportIcao = 'LOWW';

    protected array $_airportRunways = [
        '16/34',
        '11/29',
    ];

    protected string $_windComponentService = LowwWindComponentService::class;
}
