<?php
declare(strict_types=1);

namespace App\Service\Vatsim\Atis;

use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;

abstract class AbstractDecoderService
{

    use ModelAwareTrait;

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

    abstract public function getAirportName(): string;
    abstract protected function _getAtisCallsign(): string;
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
        ];
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

    public function setDataFeed(array $feed = null): void
    {
        if (!empty($feed['atis'])) {
            $atisFeed = $feed['atis'];

            foreach ($atisFeed as $atis) {
                if ($atis['callsign'] === $this->getAtisCallsign()) {
                    $this->_atisString = trim(join(' ', $atis['text_atis']));
                    return;
                }
            }
        } else {
            $this->_atisString = $this->_getDefaultAtisString();
        }
    }
}