<?php
declare(strict_types=1);

namespace App\Service\Atis;

use Cake\Http\Client;

class LowiDecoderService extends AbstractDecoderService
{

    /**
     * @var string
     */
    protected string $_atisCallsign = 'LOWI_ATIS';

    /**
     * @var string
     */
    protected string $_airportName = 'Innsbruck (LOWI)';

    /**
     * @var string
     */
    protected string $_depatureRunwayPattern = '/(?<=DEPARTURE RUNWAY )(\d\d AND \d\d|\d\d)(?= )|(?<=DEPARTURE RUNWAY )\d\d(?= )/s';

    /**
     * @var string
     */
    protected string $_arrivalRunwayPattern = '/(?<=ARRIVAL RUNWAY )(\d\d AND \d\d|\d\d)(?= )|(?<=ARRIVAL RUNWAY )\d\d(?= )/s';

    /**
     * @var string
     */
    protected string $_transitionLevelPattern = '/(?<=TRANSITION LEVEL )(\w\w\s\w\w\w)(?= )/s';

    public function getAirportName() :string
    {
        return $this->_airportName;
    }

    protected function _getAtisCallsign(): string
    {
        return $this->_atisCallsign;
    }

    protected function _getDefaultAtisString(): string
    {
        return 'THIS IS INNSBURCK INFORMATION A AT TIME 1020 DEPARTURE RUNWAY 08 AND 26 ARRIVAL RUNWAY 08 AND 26 TRANSITION LEVEL BY ATC WIND 260 DEGREES 12 KNOTS VISIBILITY MORE THAN 10 KILOMETERS CLOUDS FEW 2000 FEET FEW CB 4000 FEET BROKEN 4500 FEET TEMPERATURE 13 DEW POINT 10 QNH 1009 NOSIG ADVISE ON INITIAL CONTACT YOU HAVE INFORMATION A';
    }
}