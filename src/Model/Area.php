<?php

/**
 * Описания места в котором нужно соотнести пиксели
 * php version 7.4
 */
namespace ImageDiff\Model;

class Area
{
    /** @var int */
    public int $positionX = 0;

    /** @var int */
    public int $positionY = 0;

    /** @var int */
    public int $sizeWidth = 0;

    /** @var int */
    public int $sizeHeight = 0;

    /**
     * @return int
     */
    public function getPositionX(): int
    {
        return $this->positionX;
    }

    /**
     * @param int $positionX
     * @return Area
     */
    public function setPositionX(int $positionX): Area
    {
        $this->positionX = $positionX;
        return $this;
    }

    /**
     * @return int
     */
    public function getPositionY(): int
    {
        return $this->positionY;
    }

    /**
     * @param int $positionY
     * @return Area
     */
    public function setPositionY(int $positionY): Area
    {
        $this->positionY = $positionY;
        return $this;
    }

    /**
     * @return int
     */
    public function getSizeWidth(): int
    {
        return $this->sizeWidth;
    }

    /**
     * @param int $sizeWidth
     * @return Area
     */
    public function setSizeWidth(int $sizeWidth): Area
    {
        $this->sizeWidth = $sizeWidth;
        return $this;
    }

    /**
     * @return int
     */
    public function getSizeHeight(): int
    {
        return $this->sizeHeight;
    }

    /**
     * @param int $sizeHeight
     * @return Area
     */
    public function setSizeHeight(int $sizeHeight): Area
    {
        $this->sizeHeight = $sizeHeight;
        return $this;
    }
}
