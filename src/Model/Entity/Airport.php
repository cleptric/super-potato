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
    public const LOWW_ICAO = 'LOWW';
    public const LOWW_ATIS_CALLSIGN = 'LOWW_ATIS';
    public const LOWW_AIPORT_NAME = 'Wien-Schwechat (LOWW)';

    public const LOWI_ICAO = 'LOWI';
    public const LOWI_ATIS_CALLSIGN = 'LOWI_ATIS';
    public const LOWI_AIPORT_NAME = 'Innsbruck (LOWI)';

    public const LOWS_ICAO = 'LOWS';
    public const LOWS_ATIS_CALLSIGN = 'LOWS_ATIS';
    public const LOWS_AIPORT_NAME = 'Salzburg (LOWS)';

    public const LOWG_ICAO = 'LOWG';
    public const LOWG_ATIS_CALLSIGN = 'LOWG_ATIS';
    public const LOWG_AIPORT_NAME = 'Graz (LOWG)';

    public const LOWK_ICAO = 'LOWK';
    public const LOWK_ATIS_CALLSIGN = 'LOWK_ATIS';
    public const LOWK_AIPORT_NAME = 'Klagenfurt (LOWK)';

    public const LOWL_ICAO = 'LOWL';
    public const LOWL_ATIS_CALLSIGN = 'LOWL_ATIS';
    public const LOWL_AIPORT_NAME = 'Linz (LOWL)';

    public const LOXZ_ICAO = 'LOXZ';
    public const LOXZ_ATIS_CALLSIGN = 'LOXZ_ATIS';
    public const LOXZ_AIPORT_NAME = 'Zeltweg (LOXZ)';

    public const MISSED_APPROACH_TIMEOUT = '+10 seconds';
    public const MISSED_APPROACH_RESET = '5 minutes ago';

    public const RUNWAY_CLOSED_TIMEOUT = '+30 seconds';

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
