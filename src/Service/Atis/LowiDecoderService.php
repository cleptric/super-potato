<?php
declare(strict_types=1);

namespace App\Service\Atis;

use App\Model\Entity\Airport;

class LowiDecoderService extends AbstractDecoderService
{
    /**
     * @var string
     */
    protected string $_atisCallsign = Airport::LOWI_ATIS_CALLSIGN;

    /**
     * @var string
     */
    protected string $_airportName = Airport::LOWI_AIPORT_NAME;

    /**
     * @var string
     */
    protected string $_transitionLevelPattern = '/(?<=TRANSITION LEVEL )(\w\w\w\s\w\w\w\w\w\w\w\w\w\w)(?= )/s';

    protected function _getDepatureRunway(): array
    {
        // Handle wierd LOWI ATIS format
        if ($this->_atisString) {
            return [
                'BY ATC',
            ];
        }

        return [];
    }

    protected function _getArrivalRunway(): array
    {
        // Handle wierd LOWI ATIS format
        if ($this->_atisString) {
            return [
                'BY ATC',
            ];
        }

        return [];
    }
}
