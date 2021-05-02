<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use Cake\Datasource\ModelAwareTrait;
use MetarDecoder\Entity\DecodedMetar;
use MetarDecoder\MetarDecoder;

class MetarDecoderService
{

    use ModelAwareTrait;

    public function __construct()
    {
    }

    public function getMetarDecoder(string $metar): DecodedMetar
    {
        $decoder = new MetarDecoder();
        $decoder = $decoder->parse($metar);

        return $decoder;
    }
}