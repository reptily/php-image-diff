<?php

require __DIR__ . '/../../vendor/autoload.php';

$image = new ImageDiff\Compares("1m.png", "2m.png");
$area = (new ImageDiff\Model\Area())
    ->setPositionX(350)
    ->setPositionY(50)
    ->setSizeWidth(190)
    ->setSizeHeight(160)
;
try {
    $image->Diff(5.0, $area);
    $result = $image->Result();
    echo "Count all pixels: " . $result->getCountAllPixels() . "\n";
    echo "Count error pixels: " . $result->getCountErrorPixels() . "\n";
    echo "Error percentage: " . $result->getErrorPercentage() . "%\n";
    $image->getDiffImage("diff.png");
} catch (Exception $e) {
    var_dump($e);
}