<?php
declare(strict_types=1);

namespace App\Service\WindComponent;

class LowgWindComponentService extends AbstractWindComponentService
{
    /**
     * @var array
     */
    protected array $_trueHeadings = [
        '16C' => 169,
        '34C' => 349,
    ];
}
