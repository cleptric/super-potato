<?php
declare(strict_types=1);

namespace App\Service\Atis;

use App\Model\Entity\Airport;
use Cake\Datasource\ModelAwareTrait;
use Throwable;

class AtisDecoderService
{
    use ModelAwareTrait;

    /**
     * @var \App\Model\Entity\Airport
     */
    protected Airport $_airport;

    /**
     * @var string
     */
    protected string $_rawAtis;

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'depature_runway' => $this->_getDepatureRunway(),
            'arrival_runway' => $this->_getArrivalRunway(),
            'transition_level' => $this->_getTransitionLevel(),
        ];
    }

    /**
     * @param \App\Model\Entity\Airport $airport Airport
     * @return void
     */
    public function setAirport(Airport $airport): void
    {
        $this->_airport = $airport;
    }

    /**
     * @param string $rawAtis Atis
     * @return void
     */
    public function setAtis(string $rawAtis): void
    {
        $this->_rawAtis = $rawAtis;
    }

    /**
     * @return array
     */
    protected function _getDepatureRunway(): array
    {
        try {
            $success = preg_match($this->_airport->atis_depature_runway_pattern, $this->_rawAtis, $depatureRunway);

            if ($success === 1) {
                // Multiple depature runways
                if (strpos($depatureRunway[0], 'AND') !== false) {
                    return explode(' AND ', $depatureRunway[0]);
                }

                return [
                    $depatureRunway[0],
                ];
            }
        } catch (Throwable $t) {
        }

        return [];
    }

    /**
     * @return array
     */
    protected function _getArrivalRunway(): array
    {
        try {
            $success = preg_match($this->_airport->atis_arrival_runway_pattern, $this->_rawAtis, $arrivalRunway);

            if ($success === 1) {
                // Multiple arrival runways
                if (strpos($arrivalRunway[0], 'AND') !== false) {
                    return explode(' AND ', $arrivalRunway[0]);
                }

                return [
                    $arrivalRunway[0],
                ];
            }
        } catch (Throwable $t) {
        }

        return [];
    }

    /**
     * @return string
     */
    protected function _getTransitionLevel(): string
    {
        try {
            $success = preg_match($this->_airport->atis_transition_level_pattern, $this->_rawAtis, $transitionLevel);

            if ($success === 1) {
                return $transitionLevel[0];
            }
        } catch (Throwable $t) {
        }

        return '';
    }
}
