<?php
declare(strict_types=1);

namespace App\Service\WindComponent;

class LowwWindComponentService extends AbstractWindComponentService
{
    /**
     * @var array
     */
    protected array $_trueHeadings = [
        '11' => 116,
        '16' => 164,
        '29' => 296,
        '34' => 344,
    ];
}
