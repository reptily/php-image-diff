<?php

namespace ImageDiff;

use Exception;
use ImageDiff\DTO\DTOInterface;
use ImageDiff\Model\Area;
use ImageDiff\Model\Color;
use ImageDiff\Model\Result;
use ImageDiff\Model\Size;

class Compares
{
    /** @var string|null */
    private ?string $pathToImageOne;

    /** @var string|null */
    private ?string $pathToImageTwo;

    /** @var Size|null ?*/
    private ?Size $sizeOne;

    /** @var Size|null ?*/
    private ?Size $sizeTwo;

    /** @var DTOInterface */
    private DTOInterface $imageOne;

    /** @var DTOInterface */
    private DTOInterface $imageTwo;

    /** @var string|null (jpeg|png|bmp|gif|webp) */
    private ?string $type;

    /** @var int[] */
    const DEFAULT_ERROR_COLOR = [
        Color::RED => 255,
        Color::GREEN => 0,
        Color::BLUE => 255,
    ];

    /** @var int[] */
    const DEFAULT_EMPTY_COLOR = [
        Color::RED => 0,
        Color::GREEN => 0,
        Color::BLUE => 0,
    ];

    const ERROR_PERCENTAGE_PIXEL = 10.0;

    /* @var Color[] */
    private array $pixelsDiff = [];

    /** @var int */
    private int $countErrorPixel = 0;

    /**
     * Load constructor.
     * @param string $pathToImageOne
     * @param string $pathToImageTwo
     * @throws Exception
     */
    public function __construct(string $pathToImageOne, string $pathToImageTwo)
    {
        $this->pathToImageOne = $pathToImageOne;
        $this->pathToImageTwo = $pathToImageTwo;

        $validate = new Validate();

        if ($validate->checkType($this->pathToImageOne, $this->pathToImageTwo) === null) {
            throw new Exception('The image format should be ' . implode(", ",  Validate::IMAGE_TYPE_CORRECT));
        }

        $this->type = $validate->getCacheType();

        if ($this->type === null) {
            throw new Exception('The type is not initialized');
        }

        $this->imageOne = (new Image())->create($this->type, $this->pathToImageOne);
        $this->imageTwo = (new Image())->create($this->type, $this->pathToImageTwo);

        $this->sizeOne = $this->imageOne->getSize();
        $this->sizeTwo = $this->imageTwo->getSize();

        if (!Validate::compareSizes($this->sizeOne, $this->sizeTwo)) {
            throw new Exception('The library cannot compare images of different sizes');
        }
    }

    /**
     * @param float $errorPerPixel
     * @param Area|null $area
     */
    public function Diff(float $errorPerPixel = Compares::ERROR_PERCENTAGE_PIXEL, ?Area $area = null)
    {
        for($yi = 1; $yi < $this->sizeOne->getWidth(); $yi++) {
            for ($xi = 1; $xi < $this->sizeOne->getHeight(); $xi++) {

                if ($area !== null && !$this->inArea($area, $xi, $yi)) {
                    $this->pixelsDiff[$xi][$yi] = (new Color())
                        ->setRed(Compares::DEFAULT_EMPTY_COLOR[Color::RED])
                        ->setGreen(Compares::DEFAULT_EMPTY_COLOR[Color::GREEN])
                        ->setBlue(Compares::DEFAULT_EMPTY_COLOR[Color::BLUE])
                    ;
                    continue;
                }

                $rgbOne = imagecolorat($this->imageOne->getImage(), $xi, $yi);
                $rgbTwo = imagecolorat($this->imageTwo->getImage(), $xi, $yi);

                $colorOne = imagecolorsforindex($this->imageOne->getImage(), $rgbOne);
                $colorTwo = imagecolorsforindex($this->imageTwo->getImage(), $rgbTwo);

                $modelColorOne = (new Color())
                    ->setRed($colorOne[Color::RED])
                    ->setGreen($colorOne[Color::GREEN])
                    ->setBlue($colorOne[Color::BLUE])
                ;

                $modelColorTwo = (new Color())
                    ->setRed($colorTwo[Color::RED])
                    ->setGreen($colorTwo[Color::GREEN])
                    ->setBlue($colorTwo[Color::BLUE])
                ;

                if ($this->_diff($errorPerPixel, $modelColorOne, $modelColorTwo)) {
                    $this->pixelsDiff[$xi][$yi] = $modelColorOne;
                    $this->countErrorPixel++;
                } else {
                    $this->pixelsDiff[$xi][$yi] = (new Color())
                        ->setRed(Compares::DEFAULT_ERROR_COLOR[Color::RED])
                        ->setGreen(Compares::DEFAULT_ERROR_COLOR[Color::GREEN])
                        ->setBlue(Compares::DEFAULT_ERROR_COLOR[Color::BLUE])
                    ;
                }
            }
        }
    }

    /**
     * @return Result
     */
    public function Result(): Result
    {
        $countAllPixel = $this->sizeOne->getHeight() * $this->sizeOne->getWidth();
        $errorPercentage = $this->countErrorPixel / $countAllPixel  * 100;

        return (new Result())
            ->setCountAllPixels($countAllPixel )
            ->setCountErrorPixels($this->countErrorPixel)
            ->setErrorPercentage($errorPercentage)
        ;
    }

    public function getDiffImage(string $fileName)
    {
        $image = new Image();
        $image->getDiffImage($fileName, $this->sizeOne, $this->pixelsDiff);
    }

    /**
     * @param float $errorPerPixel
     * @param Color $colorOne
     * @param Color $colorTwo
     * @return bool
     */
    public function _diff(float $errorPerPixel, Color $colorOne, Color $colorTwo): bool
    {
        $red = [$colorOne->getRed(), $colorTwo->getRed()];
        sort($red);

        $green = [$colorOne->getGreen(), $colorTwo->getGreen()];
        sort($green);

        $blue = [$colorOne->getBlue(), $colorTwo->getBlue()];
        sort($blue);

        $redAve = $red[1] - $red[0];
        $greenAve = $green[1] - $green[0];
        $blueAve = $blue[1] - $blue[0];


        $perPixelRed = $redAve > 0 ? $redAve / $red[1] * 100 : 0;
        $perPixelGreen = $greenAve > 0 ? $greenAve / $green[1] * 100 : 0;
        $perPixelBlue = $blueAve > 0 ? $blueAve / $blue[1] * 100 : 0;

        if ($perPixelRed > 0 && $perPixelGreen > 0 && $perPixelBlue > 0) {
            $perAverage = ($perPixelRed + $perPixelGreen + $perPixelBlue ) / 3;
        } else {
            $perAverage = 0;
        }

        if ($perAverage < $errorPerPixel) {
            return false;
        }

        return true;
    }

    private function inArea(Area $area, int $x, int $y): bool
    {
        if ($area->getPositionX() <= $x && $area->getSizeWidth() + $area->getPositionX() >= $x &&
            $area->getPositionY() <= $y && $area->getSizeHeight() + $area->getPositionY() >= $y
        ) {
            return true;
        }

        return false;
    }
}
