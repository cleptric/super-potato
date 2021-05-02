<?php
declare(strict_types=1);

namespace App\Service\Vatsim\Atis;

use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;

class LowwDecoderService extends AbstractDecoderService
{

    use ModelAwareTrait;

    /**
     * @var string
     */
    protected string $_atisCallsign = 'LOWW_ATIS';

    protected string $_airportName = 'Wien-Schwechat (LOWW)';

    public function getAirportName(): string
    {
        return $this->_airportName;
    }

    protected function _getAtisCallsign(): string
    {
        return $this->_atisCallsign;
    }

    protected function _getDefaultAtisString(): string
    {
        return 'THIS IS WIEN-SCHWECHAT INFORMATION Z AT TIME 1650 LANDING RUNWAY 11 AND 16 DEPARTURE RUNWAY 16 TRANSITION LEVEL 120 WIND 150 DEGREES 12 KNOTS VISIBILITY MORE THAN 10 KILOMETERS CLOUDS FEW 5000 FEET TEMPERATURE 18 DEW POINT 9 QNH 1008 NOSIG ADVISE ON INITIAL CONTACT YOU HAVE INFORMATION Z';
    }
}