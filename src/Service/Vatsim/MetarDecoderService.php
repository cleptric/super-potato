<?php
declare(strict_types=1);

namespace App\Service\Vatsim;

use Cake\Datasource\ModelAwareTrait;
use Exception;
use MetarDecoder\Entity\DecodedMetar;
use MetarDecoder\MetarDecoder;

class MetarDecoderService
{

    use ModelAwareTrait;

    /**
     * @var string
     */
    protected ?string $_metar = null;

    public function __construct()
    {
    }

    public function getMetarDecoder(): DecodedMetar
    {
        if (empty($this->_metar)) {
            throw new Exception('No METAR is present. Did you set the METAR first?');
        }

        $decoder = new MetarDecoder();
        $decoder = $decoder->parse($this->_metar);

        return $decoder;
    }

    public function setMetar(string $metar): void
    {
        $this->_metar = $metar;
    }
}