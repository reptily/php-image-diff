<?php

namespace ImageDiff;

use ImageDiff\Model\Size;

/**
 * Class Validate
 * @package ImageDiff
 */
class Validate
{

    /** @var int|null */
    public ?int $typeImage;

    /** @var string|null */
    private ?string $cacheType;

    const IMAGE_TYPE_CORRECT = [
        1 => 'gif',
        2 => 'jpeg',
        3 => 'png',
        6 => 'bmp',
        18 => 'webp',
    ];

    /**
     * @param string $pathToImage
     * @return string|null
     */
    public function getType(string $pathToImage): ?string
    {
        $type = exif_imagetype($pathToImage);
        $this->cacheType = array_key_exists($type, self::IMAGE_TYPE_CORRECT)
            ? self::IMAGE_TYPE_CORRECT[$type]
            : null;

        return $this->cacheType;
    }

    /**
     * @param string $pathToImageOne
     * @param string $pathToImageTwo
     * @return bool
     */
    public function checkType(string $pathToImageOne, string $pathToImageTwo): bool
    {
        $typeOne = $this->getType($pathToImageOne);
        $typeTwo = $this->getType($pathToImageTwo);

        if ($typeOne === null || $typeTwo === null) {
            return false;
        }

        if ($typeOne !== $typeTwo) {
            return false;
        }

        return true;
    }

    /**
     * @return string|null
     */
    public function getCacheType(): ?string
    {
        return $this->cacheType;
    }

    /**
     * @param Size $sizeOne
     * @param Size $sizeTwo
     * @return bool
     */
    static public function compareSizes(Size $sizeOne, Size $sizeTwo): bool
    {
        if ($sizeOne->getHeight() != $sizeTwo->getHeight()) {
            return false;
        }

        if ($sizeOne->getWidth() != $sizeTwo->getWidth()) {
            return false;
        }

        return true;
    }
}
