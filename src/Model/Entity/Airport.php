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
    public const EETN_ICAO = 'EETN';
    public const EETN_ATIS_CALLSIGN = 'EETN_ATIS';
    public const EETN_AIPORT_NAME = 'Tallinn (EETN)';

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
