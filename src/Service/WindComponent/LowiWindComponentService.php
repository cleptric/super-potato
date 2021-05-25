<?php
declare(strict_types=1);

namespace App\Service\WindComponent;


class LowiWindComponentService extends AbstractWindComponentService
{
    /**
     * @var array
     */
    protected array $_trueHeadings = [
        '8' => 81,
        '26' => 261,
    ];
}