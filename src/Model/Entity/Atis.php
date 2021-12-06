<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Atis Entity
 *
 * @property string $id
 * @property string $airport_id
 * @property string|null $raw_atis
 * @property string|null $atis_letter
 * @property array|null $depature_runways
 * @property array|null $arrival_runways
 * @property string|null $transition_level
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Airport $airport
 */
class Atis extends Entity
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
        'airport_id' => true,
        'raw_atis' => true,
        'atis_letter' => true,
        'depature_runway' => true,
        'arrival_runway' => true,
        'transition_level' => true,
        'created' => true,
        'modified' => true,
    ];
}
