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

    public function getData(): array
    {
        if (empty($this->_metar)) {
            throw new Exception('No METAR is present. Did you set the METAR first?');
        }

        $decoder = new MetarDecoder();
        $decoder = $decoder->parse($this->_metar);

        return [
            'qnh_value' => $decoder->getPressure()->getValue(),
            'qnh_unit' => $decoder->getPressure()->getUnit(),
            'mean_direction' => $decoder->getSurfaceWind()->getMeanDirection()->getValue(),
            'mean_speed' => $decoder->getSurfaceWind()->getMeanSpeed()->getValue(),
            'speed_variations' => $decoder->getSurfaceWind()->getSpeedVariations(),
            'direction_variations' => [
                'from' => isset($decoder->getSurfaceWind()->getDirectionVariations()[0]) ? $decoder->getSurfaceWind()->getDirectionVariations()[0]->getValue() : null,
                'to' => isset($decoder->getSurfaceWind()->getDirectionVariations()[1]) ? $decoder->getSurfaceWind()->getDirectionVariations()[1]->getValue() : null,
            ],
            'wind_shear' => $decoder->getWindshearRunways(),
            'condition' => 'VMC',
            'raw_metar' => $decoder->getRawMetar(),
        ];
    }

    public function setMetar(string $metar): void
    {
        $this->_metar = $metar;
    }
}