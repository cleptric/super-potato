<?php
declare(strict_types=1);

namespace App\Service\Atis;

use App\Model\Entity\Airport;

class LowlDecoderService extends AbstractDecoderService
{

    /**
     * @var string
     */
    protected string $_atisCallsign = Airport::LOWL_ATIS_CALLSIGN;

    /**
     * @var string
     */
    protected string $_airportName = Airport::LOWL_AIPORT_NAME;

    /**
     * @var string
     */
    protected string $_depatureRunwayPattern = '/(?<=DEPARTURE RUNWAY )(\d\d AND \d\d)(?= )|(?<=RUNWAY )\d\d(?= )/s';

    /**
     * @var string
     */
    protected string $_arrivalRunwayPattern = '/(?<=ARRIVAL RUNWAY )(\d\d)(?= )|(?<=RUNWAY )\d\d(?= )/s';
}