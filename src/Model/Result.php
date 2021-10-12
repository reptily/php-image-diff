<?php

namespace ImageDiff\Model;

class Result
{
    /** @var int */
    private int $countAllPixels;

    /** @var int */
    private int $countErrorPixels;

    /** @var float */
    private float $errorPercentage;

    /**
     * @return int
     */
    public function getCountAllPixels(): int
    {
        return $this->countAllPixels;
    }

    /**
     * @param int $countAllPixels
     * @return Result
     */
    public function setCountAllPixels(int $countAllPixels): Result
    {
        $this->countAllPixels = $countAllPixels;
        return $this;
    }

    /**
     * @return int
     */
    public function getCountErrorPixels(): int
    {
        return $this->countErrorPixels;
    }

    /**
     * @param int $countErrorPixels
     * @return Result
     */
    public function setCountErrorPixels(int $countErrorPixels): Result
    {
        $this->countErrorPixels = $countErrorPixels;
        return $this;
    }

    /**
     * @return float
     */
    public function getErrorPercentage(): float
    {
        return $this->errorPercentage;
    }

    /**
     * @param float $errorPercentage
     * @return Result
     */
    public function setErrorPercentage(float $errorPercentage): Result
    {
        $this->errorPercentage = $errorPercentage;
        return $this;
    }
}
