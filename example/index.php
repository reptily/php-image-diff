<?php

require __DIR__ . '/../vendor/autoload.php';

$image = new ImageDiff\Compares("1.png", "2.png");
try {
    $image->Diff();
    echo "Count all pixels: " . $result->getCountAllPixels() . "\n";
    echo "Count error pixels: " . $result->getCountErrorPixels() . "\n";
    echo "Error percentage: " . $result->getErrorPercentage() . "%\n";
    $image->getDiffImage("diff.png");
} catch (Exception $e) {
    var_dump($e);
}
