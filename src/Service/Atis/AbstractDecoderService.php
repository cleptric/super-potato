<?php
declare(strict_types=1);

namespace App\Service\Atis;

use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;
use Cake\I18n\FrozenTime;

abstract class AbstractDecoderService
{

    use ModelAwareTrait;

    const ATIS_MAX_AGE = '+15 minutes';

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
    protected string $_depatureRunwayPattern = '/(?<=DEPARTURE RUNWAY )(\d\d AND \d\d|\d\d)(?= )/s';

    /**
     * @var string
     */
    protected string $_arrivalRunwayPattern = '/(?<=ARRIVAL RUNWAY )(\d\d)(?= )|(?<=LANDING RUNWAY )(\d\d AND \d\d)(?= )/s';

    /**
     * @var string
     */
    protected string $_transitionLevelPattern = '/(?<=TRANSITION LEVEL )(\d\d|\d\d\d)(?= )/s';

    /**
     * @var string
     */
    protected string $_timePattern = '/(?<=AT TIME )\d\d\d\d(?= )/s';

    abstract protected function _getDefaultAtisString(): string;

    public function getData(): array
    {
        return [
            'airport_name' => $this->getAirportName(),
            'atis_letter' => $this->getAtisLetter(),
            'depature_runway' => $this->getDepatureRunway(),
            'arrival_runway' => $this->getArrivalRunway(),
            'transition_level' => $this->getTransitionLevel(),
            'time' => $this->getTime(),
            'outdated' => $this->isAtisOutdated(),
            'raw' => $this->_atisString,
        ];
    }

    public function getAirportName(): string
    {
        return $this->_airportName;
    }

    public function getAtisLetter(): string
    {
        $success = preg_match($this->_atisLetterPattern, $this->_atisString, $atisLetter);

        if ($success === 1) {
            return $atisLetter[0];
        }

        return '';
    }

    public function getDepatureRunway(): array
    {
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

        return [];
    }

    public function getArrivalRunway(): array
    {
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

        return [];
    }

    public function getTransitionLevel(): string
    {
        $success = preg_match($this->_transitionLevelPattern, $this->_atisString, $transitionLevel);

        if ($success === 1) {
            return $transitionLevel[0];
        }

        return '';
    }

    public function getTime(): string
    {
        $success = preg_match($this->_timePattern, $this->_atisString, $time);

        if ($success === 1) {
            return $time[0];
        }

        return '';
    }

    public function isAtisOutdated(): bool
    {
        return !($this->_atisUpdateTime->modify(self::ATIS_MAX_AGE) > new FrozenTime());
    }

    public function setDataFeed(array $feed = null): void
    {
        foreach ($feed['data']['atis'] as $atisCallsign => $atis) {
            if ($atisCallsign === $this->_getAtisCallsign()) {
                $this->_atisString = $atis['raw'];
                $this->_atisUpdateTime = new FrozenTime($atis['last_updated']);;
                return;
            }
        }

        $this->_atisString = $this->_getDefaultAtisString();
    }

    protected function _getAtisCallsign(): string
    {
        return $this->_atisCallsign;
    }
}