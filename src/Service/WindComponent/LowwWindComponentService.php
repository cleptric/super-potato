<?php
declare(strict_types=1);

namespace App\Service\WindComponent;

class LowwWindComponentService extends AbstractWindComponentService
{
    /**
     * @var array
     */
    protected array $_trueHeadings = [
        '11' => 115,
        '16' => 164,
        '29' => 295,
        '34' => 344,
    ];
}
