<?php
declare(strict_types=1);

namespace App\Service\WindComponent;


class LowiWindComponentService extends AbstractWindComponentService
{
    /**
     * @var array
     */
    protected array $_trueHeadings = [
        '08' => 81,
        '26' => 261,
    ];
}