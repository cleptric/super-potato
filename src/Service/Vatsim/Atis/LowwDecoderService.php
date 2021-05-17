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

    /**
     * @var string
     */
    protected string $_airportName = 'Wien-Schwechat (LOWW)';

    protected function _getDefaultAtisString(): string
    {
        return 'THIS IS WIEN-SCHWECHAT INFORMATION A AT TIME 1020 ARRIVAL RUNWAY 29 DEPARTURE RUNWAY 29 TRANSITION LEVEL 120 WIND 150 DEGREES 12 KNOTS VISIBILITY MORE THAN 10 KILOMETERS CLOUDS FEW 5000 FEET TEMPERATURE 18 DEW POINT 9 QNH 1008 NOSIG ADVISE ON INITIAL CONTACT YOU HAVE INFORMATION A';
    }
}