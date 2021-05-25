<?php
declare(strict_types=1);

namespace App\Service\WindComponent;


class LowkWindComponentService extends AbstractWindComponentService
{
    /**
     * @var array
     */
    protected array $_trueHeadings = [
        '10L' => 107,
        '28R' => 287,
    ];
}