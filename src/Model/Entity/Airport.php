<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Airport Entity
 *
 * @property string $id
 * @property string $name
 * @property array|null $visual_depatures
 * @property array|null $closed_runways
 * @property \Cake\I18n\FrozenTime|null $closed_runways_timeout
 * @property bool $missed_approach
 * @property \Cake\I18n\FrozenTime|null $missed_approach_timeout
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class Airport extends Entity
{
    const LOWW_ICAO = 'LOWW';
    const LOWW_ATIS_CALLSIGN = 'LOWW_ATIS';
    const LOWW_AIPORT_NAME = 'Wien-Schwechat (LOWW)';

    const LOWI_ICAO = 'LOWI';
    const LOWI_ATIS_CALLSIGN = 'LOWI_ATIS';
    const LOWI_AIPORT_NAME = 'Innsburck (LOWI)';

    const LOWS_ICAO = 'LOWS';
    const LOWS_ATIS_CALLSIGN = 'LOWS_ATIS';
    const LOWS_AIPORT_NAME = 'Salzburg (LOWS)';

    const LOWG_ICAO = 'LOWG';
    const LOWG_ATIS_CALLSIGN = 'LOWG_ATIS';
    const LOWG_AIPORT_NAME = 'Graz (LOWG)';

    const LOWK_ICAO = 'LOWK';
    const LOWK_ATIS_CALLSIGN = 'LOWK_ATIS';
    const LOWK_AIPORT_NAME = 'Klagenfurt (LOWK)';

    const LOWL_ICAO = 'LOWL';
    const LOWL_ATIS_CALLSIGN = 'LOWL_ATIS';
    const LOWL_AIPORT_NAME = 'Linz (LOWL)';

    const LOXZ_ICAO = 'LOXZ';
    const LOXZ_ATIS_CALLSIGN = 'LOXZ_ATIS';
    const LOXZ_AIPORT_NAME = 'Zeltweg (LOXZ)';

    const MISSED_APPROACH_TIMEOUT = '+30 seconds';

    const RUNWAY_CLOSED_TIMEOUT = '+30 seconds';

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => false,
    ];
}
