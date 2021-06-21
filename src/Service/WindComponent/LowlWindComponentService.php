<?php
declare(strict_types=1);

namespace App\Service\WindComponent;

class LowlWindComponentService extends AbstractWindComponentService
{
    /**
     * @var array
     */
    protected array $_trueHeadings = [
        '08' => 87,
        '26' => 267,
    ];
}
