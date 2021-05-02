<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Feed Entity
 *
 * @property string $id
 * @property array $data
 * @property \Cake\I18n\FrozenTime|null $created
 */
class Feed extends Entity
{
    /**
     * @var array
     */
    protected $_accessible = [
        'data' => true,
        'created' => true,
    ];
}
