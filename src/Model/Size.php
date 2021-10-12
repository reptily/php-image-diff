<?php

namespace ImageDiff\Model;

class Size
{
    /** @var int */
    private int $width = 0;

    /** @var int */
    private int $height = 0;

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return Size
     */
    public function setWidth(int $width): Size
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return Size
     */
    public function setHeight(int $height): Size
    {
        $this->height = $height;
        return $this;
    }
}
