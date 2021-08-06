<?php
declare(strict_types=1);

namespace App\Service\Atis;

use App\Model\Entity\Airport;

class EddmDecoderService extends AbstractDecoderService
{
    /**
     * @var string
     */
    protected string $_atisCallsign = Airport::EDDM_ATIS_CALLSIGN;

    /**
     * @var string
     */
    protected string $_airportName = Airport::EDDM_AIPORT_NAME;

    /**
     * @var string
     */
    protected string $_depatureRunwayPattern = '/(?<=DEPARTURE RUNWAY )(\d\d AND \d\d|\d\d)(?= )/s';

    /**
     * @var string
     */
    protected string $_arrivalRunwayPattern = '/(?<=ARRIVAL RUNWAY )(\d\d)(?= )|(?<=LANDING RUNWAY )(\d\d AND \d\d)(?= )/s';
}
