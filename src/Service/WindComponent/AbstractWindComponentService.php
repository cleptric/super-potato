<?php
declare(strict_types=1);

namespace App\Service\WindComponent;

abstract class AbstractWindComponentService
{

    /**
     * @var int|null
     */
    protected ?int $_meanDirection;

    /**
     * @var int|null
     */
    protected ?int $_meanSpeed;

    public function setMeanDirection(?int $meanDirection): void
    {
        $this->_meanDirection = $meanDirection;
    }

    public function setMeanSpeed(?int $meanSpeed): void
    {
        $this->_meanSpeed = $meanSpeed;
    }

    public function getData(): array
    {
        $data = [];

        foreach ($this->_trueHeadings as $runway => $trueHeading) {
            $data[$runway] = [
                'cross_wind' => $this->_calcutlateCrossWindComponent($trueHeading),
                'head_tail_wind' => $this->_calcutlateHeadTailWindComponent($trueHeading),
            ];
        }

        return $data;
    }

    protected function _calcutlateCrossWindComponent($trueHeading)
    {
        return abs(round(sin(deg2rad($this->_meanDirection - $trueHeading)) * $this->_meanSpeed));
    }

    protected function _calcutlateHeadTailWindComponent($trueHeading)
    {
        return round(cos(deg2rad($this->_meanDirection - $trueHeading)) * $this->_meanSpeed);
    }
}