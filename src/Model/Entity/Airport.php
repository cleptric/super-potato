<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Airport Entity
 *
 * @property string $id
 * @property string $organization_id
 * @property string $name
 * @property string $icao
 * @property string $charts_url
 * @property string $atis_callsign
 * @property string|null $atis_depature_runway_pattern
 * @property string|null $atis_arrival_runway_pattern
 * @property string|null $atis_transition_level_pattern
 * @property \Cake\I18n\FrozenTime|null $closed_runways_timeout
 * @property bool $missed_approach
 * @property \Cake\I18n\FrozenTime|null $missed_approach_timeout
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property array|null $visual_depatures
 * @property array|null $closed_runways
 *
 * @property \Cake\ORM\Entity $organization
 * @property \App\Model\Entity\Runway[] $runways
 * @property \App\Model\Entity\Metar[] $metar
 */
class Airport extends Entity
{
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
     * @var array<string, bool>
     */
    protected $_accessible = [
        '*' => false,
    ];
}
