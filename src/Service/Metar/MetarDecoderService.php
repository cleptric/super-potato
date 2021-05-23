<?php
declare(strict_types=1);

namespace App\Service\Metar;

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

    /**
     * @var MetarDecoder
     */
    protected ?DecodedMetar $_decoder = null;

    public function getData(): array
    {
        if (empty($this->_metar)) {
            throw new Exception('No METAR is present. Did you set the METAR first?');
        }

        $decoder = new MetarDecoder();
        $this->_decoder = $decoder->parse($this->_metar);

        return [
            'qnh_value' => $this->_decoder->getPressure()->getValue(),
            'qnh_unit' => $this->_decoder->getPressure()->getUnit(),
            'mean_direction' => !empty($this->_decoder->getSurfaceWind()->getMeanDirection()) ? $this->_decoder->getSurfaceWind()->getMeanDirection()->getValue() : null,
            'is_variable' => $this->_decoder->getSurfaceWind()->withVariableDirection(),
            'mean_speed' => $this->_decoder->getSurfaceWind()->getMeanSpeed()->getValue(),
            'speed_variations' => !empty($this->_decoder->getSurfaceWind()->getSpeedVariations()) ? $this->_decoder->getSurfaceWind()->getSpeedVariations()->getValue() : null,
            'wind_shear_runways' => $this->_decoder->getWindshearRunways(),
            'wind_shear_all_runways' => $this->_decoder->getWindshearAllRunways(),
            'condition' => $this->getConditions(),
            'raw_metar' => $this->_decoder->getRawMetar(),
        ];
    }

    public function setMetar(string $metar): void
    {
        $this->_metar = $metar;
    }

    public function getConditions(): string 
    {
        return 'VMC';
    }
}