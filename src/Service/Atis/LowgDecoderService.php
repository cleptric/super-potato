<?php
declare(strict_types=1);

namespace App\Service\Atis;

use App\Model\Entity\Airport;

class LowgDecoderService extends AbstractDecoderService
{

    /**
     * @var string
     */
    protected string $_atisCallsign = Airport::LOWG_ATIS_CALLSIGN;

    /**
     * @var string
     */
    protected string $_airportName = Airport::LOWG_AIPORT_NAME;

    /**
     * @var string
     */
    protected string $_depatureRunwayPattern = '/(?<=DEPARTURE RUNWAY )(\d\d AND \d\d)(?= )|(?<=RUNWAY )\d\d(?= )/s';

    /**
     * @var string
     */
    protected string $_arrivalRunwayPattern = '/(?<=ARRIVAL RUNWAY )(\d\d)(?= )|(?<=RUNWAY )\d\d(?= )/s';
}