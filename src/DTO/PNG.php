<?php

namespace ImageDiff\DTO;

use Exception;
use ImageDiff\Model\Size;

class PNG implements DTOInterface
{
    /** @var Size */
    private Size $size;

    private $image;

    public function load(string $pathToImage): DTOInterface
    {
        $this->image = @imagecreatefrompng($pathToImage);
        if ($this->image === false) {
            throw new Exception('Not possible to load');
        }

        $sizeNative = getimagesize($pathToImage);

        $this->size = (new Size())
            ->setWidth($sizeNative[1])
            ->setHeight($sizeNative[0])
            ;

        return $this;
    }

    /**
     * @return Size
     */
    public function getSize(): Size
    {
        return $this->size;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function create(string $fileName, $imageDiff)
    {
        imagepng($imageDiff, $fileName);
        imagedestroy($imageDiff);
    }
}
