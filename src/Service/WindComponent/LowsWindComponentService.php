<?php
declare(strict_types=1);

namespace App\Service\WindComponent;


class LowsWindComponentService extends AbstractWindComponentService
{
    /**
     * @var array
     */
    protected array $_trueHeadings = [
        '15' => 157,
        '33' => 337,
    ];
}