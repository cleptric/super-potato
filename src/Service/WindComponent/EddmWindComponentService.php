<?php
declare(strict_types=1);

namespace App\Service\WindComponent;

class EddmWindComponentService extends AbstractWindComponentService
{
    /**
     * @var array
     */
    protected array $_trueHeadings = [
        '26R' => 263,
        '26L' => 263,
        '08R' => 83,
        '08L' => 83,
    ];
}
