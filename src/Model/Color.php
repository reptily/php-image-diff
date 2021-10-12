<?php

namespace ImageDiff\Model;

class Color
{
    const RED = 'red';
    const GREEN = 'green';
    const BLUE = 'blue';

    /** @var int */
    public int $red = 0;
    /** @var int */
    public int $green = 0;
    /** @var int */
    public int $blue = 0;

    /**
     * @return int
     */
    public function getRed(): int
    {
        return $this->red;
    }

    /**
     * @param int $red
     * @return Color
     */
    public function setRed(int $red): Color
    {
        $this->red = $red;
        return $this;
    }

    /**
     * @return int
     */
    public function getGreen(): int
    {
        return $this->green;
    }

    /**
     * @param int $green
     * @return Color
     */
    public function setGreen(int $green): Color
    {
        $this->green = $green;
        return $this;
    }

    /**
     * @return int
     */
    public function getBlue(): int
    {
        return $this->blue;
    }

    /**
     * @param int $blue
     * @return Color
     */
    public function setBlue(int $blue): Color
    {
        $this->blue = $blue;
        return $this;
    }

}