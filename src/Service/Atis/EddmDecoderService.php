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
    protected string $_depatureRunwayPattern = '/(?<=RUNWAYS IN USE )(\d\d\w AND \d\d\w)/s';

    /**
     * @var string
     */
    protected string $_arrivalRunwayPattern = '/(?<=RUNWAYS IN USE )(\d\d\w AND \d\d\w)/s';

    /**
     * @var string
     */
    protected string $_transitionLevelPattern = '/(?<=TRL )(\d\d)(?= )/s';
}
