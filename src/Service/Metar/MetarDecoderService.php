<?php
declare(strict_types=1);

namespace App\Service\Metar;

use Cake\Datasource\ModelAwareTrait;
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
     * @var \MetarDecoder\MetarDecoder
     */
    protected ?DecodedMetar $_decoder = null;

    public function getData(): array
    {
        if (empty($this->_metar)) {
            return [
                'qnh_value' => null,
                'qnh_unit' => null,
                'mean_direction' => null,
                'is_variable' => null,
                'mean_speed' => null,
                'speed_variations' => null,
                'wind_shear_runways' => null,
                'wind_shear_all_runways' => null,
                'condition' => null,
                'raw_metar' => null,
            ];
        }

        $decoder = new MetarDecoder();
        $this->_decoder = $decoder->parse($this->_metar);

        return [
            'qnh_value' => !empty($this->_decoder->getPressure()) ? $this->_decoder->getPressure()->getValue() : null,
            'qnh_unit' => !empty($this->_decoder->getPressure()) ? $this->_decoder->getPressure()->getUnit() : null,
            'mean_direction' => !empty($this->_decoder->getSurfaceWind()) && !empty($this->_decoder->getSurfaceWind()->getMeanDirection()) ? $this->_decoder->getSurfaceWind()->getMeanDirection()->getValue() : null,
            'is_variable' => !empty($this->_decoder->getSurfaceWind()) ? $this->_decoder->getSurfaceWind()->withVariableDirection() : null,
            'mean_speed' => !empty($this->_decoder->getSurfaceWind()) ? $this->_decoder->getSurfaceWind()->getMeanSpeed()->getValue() : null,
            'speed_variations' => !empty($this->_decoder->getSurfaceWind()) && !empty($this->_decoder->getSurfaceWind()->getSpeedVariations()) ? $this->_decoder->getSurfaceWind()->getSpeedVariations()->getValue() : null,
            'wind_shear_runways' => !empty($this->_decoder->getWindshearRunways()) ? $this->_decoder->getWindshearRunways() : null,
            'wind_shear_all_runways' => !empty($this->_decoder->getWindshearAllRunways()) ? $this->_decoder->getWindshearAllRunways() : null,
            'raw_metar' => !empty($this->_decoder->getRawMetar()) ? $this->_decoder->getRawMetar() : null,
            'condition' => $this->_getCondition(),
        ];
    }

    public function setMetar(?string $metar): void
    {
        $this->_metar = $metar;
    }

    protected function _getCondition(): string
    {
        $clouds = $this->_decoder->getClouds();
        $cloudLayer = [];
        if (isset($clouds[0])) {
            if ($clouds[0]->getAmount() === 'OVC' || $clouds[0]->getAmount() === 'BKN') {
                $cloudLayer = [
                'type' => $clouds[0]->getAmount(),
                'base' => $clouds[0]->getBaseHeight()->getValue(),
                ];
            }
        }

        $visiblityObj = $this->_decoder->getVisibility();
        $visiblity = null;
        if (!empty($visiblityObj)) {
            $visiblity = $visiblityObj->getVisibility()->getValue();
        }

        $rvr = $this->_decoder->getRunwaysVisualRange();
        $runwayRvr = [];
        if (!empty($rvr)) {
            foreach ($rvr as $rwy) {
                if ($rwy->getVisualRange()->getValue() < 600) {
                    $runwayRvr = [
                        'runway' => $rwy->getRunway(),
                        'rvr' => $rwy->getVisualRange()->getValue(),
                    ];
                }
            }
        }

        // LVP 3
        if (
            // RVR smaller 350m AND
            !empty($runwayRvr) && $runwayRvr['rvr'] < 350 &&
            // Celing below 200ft
            !empty($cloudLayer) && $cloudLayer['base'] < 200
        ) {
            return 'LVP 3';
        }

        // LVP 2
        if (
            // RVR smaller 600m OR
            !empty($runwayRvr) && $runwayRvr['rvr'] < 600 ||
            // Celing below 200ft
            !empty($cloudLayer) && $cloudLayer['base'] < 200
        ) {
            return 'LVP 2';
        }

        // LVP 1
        if (
            // Celing below 200ft
            !empty($cloudLayer) && $cloudLayer['base'] < 200
        ) {
            return 'LVP 1';
        }

        return 'VMC';
    }
}
