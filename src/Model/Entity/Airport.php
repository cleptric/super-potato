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

    const MISSED_APPROACH_TIMEOUT = '+30 seconds';

    const RUNWAY_CLOSED_TIMEOUT = '+30 seconds';
}
