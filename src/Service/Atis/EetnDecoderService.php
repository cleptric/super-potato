<?php
declare(strict_types=1);

namespace App\Service\Atis;

use App\Model\Entity\Airport;

class EetnDecoderService extends AbstractDecoderService
{
    /**
     * @var string
     */
    protected string $_atisCallsign = Airport::EETN_ATIS_CALLSIGN;

    /**
     * @var string
     */
    protected string $_airportName = Airport::EETN_AIPORT_NAME;

    /**
     * @var string
     */
    protected string $_depatureRunwayPattern = '/(?<=RUNWAY )(\d\d)(?= IN USE)/s';

    /**
     * @var string
     */
    protected string $_arrivalRunwayPattern = '/(?<=RUNWAY )(\d\d)(?= IN USE)/s';

    /**
     * @var string
     */
    protected string $_transitionLevelPattern = '/(?<=TRANSITION LEVEL )(\d\d)(?= )/s';
}
