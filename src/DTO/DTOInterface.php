<?php

namespace ImageDiff\DTO;

use ImageDiff\Model\Size;

interface DTOInterface
{
    public function load(string $pathToImage): DTOInterface;
    public function getSize(): Size;
    public function getImage();
    public function create(string $fileName, $imageDiff);
}