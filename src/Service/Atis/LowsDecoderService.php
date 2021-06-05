<?php
declare(strict_types=1);

namespace App\Service\Atis;

use App\Model\Entity\Airport;

class LowsDecoderService extends AbstractDecoderService
{

    /**
     * @var string
     */
    protected string $_atisCallsign = Airport::LOWS_ATIS_CALLSIGN;

    /**
     * @var string
     */
    protected string $_airportName = Airport::LOWS_AIPORT_NAME;

    /**
     * @var string
     */
    protected string $_depatureRunwayPattern = '/(?<=DEPARTURE RUNWAY )(\d\d AND \d\d|\d\d)(?= )|(?<=RUNWAY )(\d\d AND \d\d|\d\d)(?= IN USE)/s';

    /**
     * @var string
     */
    protected string $_arrivalRunwayPattern = '/(?<=ARRIVAL RUNWAY )(\d\d AND \d\d|\d\d)(?= )|(?<=RUNWAY )(\d\d AND \d\d|\d\d)(?= IN USE)|(?<=LANDING RUNWAY )(\d\d AND \d\d|\d\d)(?= )/s';
}