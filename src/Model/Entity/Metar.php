<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Metar Entity
 *
 * @property string $id
 * @property string $airport_id
 * @property string $raw_metar
 * @property int|null $qnh_value
 * @property string|null $qnh_unit
 * @property string|null $qnh_trend
 * @property int|null $mean_direction
 * @property int|null $is_variable
 * @property int|null $mean_speed
 * @property int|null $speed_variations
 * @property string|null $wind_shear_runways
 * @property int|null $wind_shear_all_runways
 * @property string|null $conditions
 * @property array|null $rvr
 * @property \Cake\I18n\FrozenTime|null $created
 */
class Metar extends Entity
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
        'raw_metar' => true,
        'qnh_value' => true,
        'qnh_unit' => true,
        'qnh_trend' => true,
        'mean_direction' => true,
        'is_variable' => true,
        'mean_speed' => true,
        'speed_variations' => true,
        'wind_shear_runways' => true,
        'wind_shear_all_runways' => true,
        'conditions' => true,
        'rvr' => true,
        'created' => true,
    ];
}
