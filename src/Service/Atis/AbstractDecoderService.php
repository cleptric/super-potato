<?php
declare(strict_types=1);

namespace App\Service\Atis;

use Cake\Datasource\ModelAwareTrait;
use Cake\I18n\FrozenTime;
use Throwable;

abstract class AbstractDecoderService
{
    use ModelAwareTrait;

    public const ATIS_MAX_AGE = '+15 minutes';

    /**
     * @var string
     */
    protected string $_atisCallsign;

    /**
     * @var string
     */
    protected string $_airportName;

    /**
     * @var string|null
     */
    protected ?string $_atisString = null;

    /**
     * @var string|null
     */
    protected ?FrozenTime $_atisUpdateTime = null;

    /**
     * @var string
     */
    protected string $_atisLetterPattern = '/(?<=INFORMATION )[A-Z](?= )/s';

    /**
     * @var string
     */
    protected string $_transitionLevelPattern = '/(?<=TRANSITION LEVEL )(\d\d|\d\d\d)(?= )/s';

    /**
     * @var string
     */
    protected string $_timePattern = '/(?<=AT TIME )\d\d\d\d(?= )/s';

    public function getData(): array
    {
        return [
            'airport_name' => $this->_getAirportName(),
            'atis_letter' => $this->_getAtisLetter(),
            'depature_runway' => $this->_getDepatureRunway(),
            'arrival_runway' => $this->_getArrivalRunway(),
            'transition_level' => $this->_getTransitionLevel(),
            'time' => $this->_getTime(),
            'outdated' => $this->_isAtisOutdated(),
        ];
    }

    public function setDataFeed(?array $feed = null): void
    {
        if (!empty($feed['data']['atis'])) {
            foreach ($feed['data']['atis'] as $atisCallsign => $atis) {
                if ($atisCallsign === $this->_getAtisCallsign()) {
                    $this->_atisString = $atis['raw'];
                    $this->_atisUpdateTime = new FrozenTime($atis['last_updated']);

                    return;
                }
            }
        }
    }

    protected function _getAirportName(): string
    {
        return $this->_airportName;
    }

    protected function _getAtisCallsign(): string
    {
        return $this->_atisCallsign;
    }

    protected function _getAtisLetter(): string
    {
        try {
            $success = preg_match($this->_atisLetterPattern, $this->_atisString, $atisLetter);

            if ($success === 1) {
                return $atisLetter[0];
            }
        } catch (Throwable $t) {
        }

        return '';
    }

    protected function _getDepatureRunway(): array
    {
        try {
            $success = preg_match($this->_depatureRunwayPattern, $this->_atisString, $depatureRunway);

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

    protected function _getArrivalRunway(): array
    {
        try {
            $success = preg_match($this->_arrivalRunwayPattern, $this->_atisString, $arrivalRunway);

            if ($success === 1) {
                // Multiple depature runways
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

    protected function _getTransitionLevel(): string
    {
        try {
            $success = preg_match($this->_transitionLevelPattern, $this->_atisString, $transitionLevel);

            if ($success === 1) {
                return $transitionLevel[0];
            }
        } catch (Throwable $t) {
        }

        return '';
    }

    protected function _getTime(): string
    {
        try {
            $success = preg_match($this->_timePattern, $this->_atisString, $time);

            if ($success === 1) {
                return $time[0];
            }
        } catch (Throwable $t) {
        }

        return '';
    }

    protected function _isAtisOutdated(): bool
    {
        try {
            return !($this->_atisUpdateTime->modify(self::ATIS_MAX_AGE) > new FrozenTime());
        } catch (Throwable $t) {
        }

        return true;
    }
}
