<?php
declare(strict_types=1);

namespace App\Service\WindComponent;

abstract class AbstractWindComponentService
{
    /**
     * @var int|null
     */
    protected ?int $_meanDirection = null;

    /**
     * @var int|null
     */
    protected ?int $_meanSpeed = null;

    /**
     * @param int|null $meanDirection Mean direction
     * @return void
     */
    public function setMeanDirection(?int $meanDirection): void
    {
        $this->_meanDirection = $meanDirection;
    }

    /**
     * @param int|null $meanSpeed Mean speed
     * @return void
     */
    public function setMeanSpeed(?int $meanSpeed): void
    {
        $this->_meanSpeed = $meanSpeed;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $data = [];

        foreach ($this->_trueHeadings as $runway => $trueHeading) {
            $windComponents = null;

            if (!is_null($this->_meanDirection) && !is_null($this->_meanSpeed)) {
                $crossWind = $this->_calcutlateCrossWindComponent($trueHeading);
                $headTailWind = $this->_calcutlateHeadTailWindComponent($trueHeading);

                $windComponents = $crossWind . '/' . $headTailWind;
            }

            $data[$runway] = $windComponents;
        }

        return $data;
    }

    /**
     * @param int $trueHeading True heading
     * @return string
     */
    protected function _calcutlateCrossWindComponent(int $trueHeading): string
    {
        $crossWind = abs(round(sin(deg2rad($this->_meanDirection - $trueHeading)) * $this->_meanSpeed));

        return $crossWind . 'X';
    }

    /**
     * @param int $trueHeading True heading
     * @return string
     */
    protected function _calcutlateHeadTailWindComponent(int $trueHeading): string
    {
        $headTailWind = round(cos(deg2rad($this->_meanDirection - $trueHeading)) * $this->_meanSpeed);

        if ($headTailWind > 0) {
            return abs($headTailWind) . 'H';
        } else {
            return abs($headTailWind) . 'T';
        }
    }
}
