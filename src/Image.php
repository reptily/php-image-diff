<?php

namespace ImageDiff;

use Exception;
use ImageDiff\DTO\DTOInterface;
use ImageDiff\Model\Size;

class Image
{
    /** @var Size */
    private Size $size;

    /**
     * @param string $type
     * @param string $pathToImage
     * @return DTOInterface
     */
    public function create(string $type, string $pathToImage): DTOInterface
    {
        $type = 'ImageDiff\\DTO\\' . mb_strtoupper($type);
        $image = new $type;
        $image->load($pathToImage);
        $this->size = $image->getSize();
        return $image;
    }

    /**
     * @param string $fileName
     * @param Size $size
     * @patam Color[] $pixels
     * @throws Exception
     */
    public function getDiffImage(string $fileName, Size $size, array $pixels)
    {
        $ext = explode('.', $fileName)[1] ?? null;

        if ($ext === null) {
            throw new Exception('Extension not found');
        }

        if (!in_array($ext, Validate::IMAGE_TYPE_CORRECT)) {
            throw new Exception('The image format should be ' . implode(", ", Validate::IMAGE_TYPE_CORRECT));
        }

        $type = 'ImageDiff\\DTO\\' . mb_strtoupper($ext);
        $image = new $type;

        $imageDiff = imagecreatetruecolor($size->getHeight(), $size->getWidth());

        for($yi = 1; $yi < $size->getWidth(); $yi++) {
            for ($xi = 1; $xi < $size->getHeight(); $xi++) {
                $red = $pixels[$xi][$yi]->getRed();
                $green = $pixels[$xi][$yi]->getGreen();
                $blue = $pixels[$xi][$yi]->getBlue();

                $color = imagecolorallocate($imageDiff, $red, $green, $blue);
                imagesetpixel($imageDiff, $xi, $yi, $color);
            }
        }

        $image->create($fileName, $imageDiff);
    }
}
