<?php
declare(strict_types=1);

namespace App\Service\Vatsim\Atis;

use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;

class LowsDecoderService extends AbstractDecoderService
{

    use ModelAwareTrait;

    /**
     * @var string
     */
    protected string $_atisCallsign = 'LOWS_ATIS';

    /**
     * @var string
     */
    protected string $_airportName = 'Salzburg (LOWS)';

    /**
     * @var string
     */
    protected string $_depatureRunwayPattern = '/(?<=DEPARTURE RUNWAY )(\d\d AND \d\d|\d\d)(?= )|(?<=RUNWAY )\d\d(?= )/s';

    /**
     * @var string
     */
    protected string $_arrivalRunwayPattern = '/(?<=ARRIVAL RUNWAY )(\d\d)(?= )|(?<=RUNWAY )\d\d(?= )/s';

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
        return 'THIS IS SALZBURG INFORMATION A AT TIME 1020 RUNWAY 15 IN USE TRANSITION LEVEL 120 WIND 310 DEGREES 12 KNOTS VISIBILITY MORE THAN 10 KILOMETERS CLOUDS FEW 2000 FEET FEW CB 4000 FEET BROKEN 4500 FEET TEMPERATURE 13 DEW POINT 10 QNH 1009 NOSIG ADVISE ON INITIAL CONTACT YOU HAVE INFORMATION A';
    }
}