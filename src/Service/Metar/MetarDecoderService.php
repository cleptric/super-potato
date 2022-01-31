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
                'rvr' => null,
                'condition' => null,
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
            'rvr' => $this->_getRvr(),
            'condition' => $this->_getCondition(),
        ];
    }

    public function setMetar(?string $metar): void
    {
        $this->_metar = $metar;
    }

    protected function _getRvr(): array
    {
        $rvr = $this->_decoder->getRunwaysVisualRange();
        $runwayRvr = [];
        if (!empty($rvr)) {
            foreach ($rvr as $rwy) {
                if ($rwy->getVisualRange()) {
                    $runwayRvr[$rwy->getRunway()] = $rwy->getVisualRange()->getValue() . $rwy->getPastTendency();
                }
                // Check for variable RVR (R08L/0700V1700U)
                if ($rwy->isVariable()) {
                    $interval = [];
                    foreach ($rwy->getVisualRangeInterval() as $rwyInterval) {
                        $interval[] = $rwyInterval->getValue();
                    }
                    $runwayRvr[$rwy->getRunway()] = implode('V', $interval) . $rwy->getPastTendency();
                }
            }
        }

        return $runwayRvr;
    }

    protected function _getCondition(): string
    {
        $clouds = $this->_decoder->getClouds();
        $cloudLayer = [];
        if (!empty($clouds)) {
            foreach ($clouds as $cloud) {
                // Ignore higher OVC/BKN layers
                if (isset($cloudLayer['base']) && $cloudLayer['base'] < $cloud->getBaseHeight()->getValue()) {
                    continue;
                }
                if ($cloud->getAmount() === 'OVC' || $cloud->getAmount() === 'BKN') {
                    $cloudLayer = [
                        'type' => $cloud->getAmount(),
                        'base' => $cloud->getBaseHeight()->getValue(),
                    ];
                }
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
                // Ignore higher RVR, as we use the lowest
                if (isset($runwayRvr['rvr']) && $runwayRvr['rvr'] < $rwy->getVisualRange()->getValue()) {
                    continue;
                }
                // Ignore variable RVR for now
                if ($rwy->getVisualRange()) {
                    if ($rwy->getVisualRange()->getValue() <= 1000) {
                        $runwayRvr = [
                            'runway' => $rwy->getRunway(),
                            'rvr' => $rwy->getVisualRange()->getValue(),
                        ];
                    }
                }
            }
        }

        // LVP 3
        if (
            // RVR equal/smaller 600m AND
            !empty($runwayRvr) && $runwayRvr['rvr'] <= 600 &&
            // Celing below 200ft
            !empty($cloudLayer) && $cloudLayer['base'] < 200
        ) {
            return 'LVP CAT III';
        }

        // LVP 1
        if (
            // Celing at/below 300ft OR
            !empty($cloudLayer) && $cloudLayer['base'] <= 300 ||
            // RVR equal/smaller 1000m
            !empty($runwayRvr) && $runwayRvr['rvr'] <= 1000
        ) {
            return 'LVP CAT I';
        }

        return 'VMC';
    }
}
