# Install
```bash
composer require reptily/php-image-diff
```

## Example

1. A simple example for determining the difference between two images.

First image\
<img src="https://sun9-22.userapi.com/impg/IoCl6NF_DIdogNmuNSbIBeb9234egwh77roY_w/jk-u-txXKGo.jpg?size=100x100&quality=96&sign=b1d54ac79853405d704d0be366114a45&type=album">\
Second image\
<img src="https://sun9-66.userapi.com/impg/mWfKVKAMWoHGzHNcXNOjpk3SrDIu5Z_ccofScQ/lzY3HmhSEhc.jpg?size=100x100&quality=96&sign=27fe8c0f1fd83fd3446e047fcb41f13b&type=album">
```php
<?php

require __DIR__ . '/vendor/autoload.php';

$image = new ImageDiff\Compares("1.png", "2.png");
try {
    $image->Diff();
    $image->getDiffImage("diff.png");
} catch (Exception $e) {
    var_dump($e);
}
```
Result image compares\
<img src="https://sun9-72.userapi.com/impg/JXVsUuk0R-cjSAOBCu7VUjkGbNyHDzZKcOHT9g/U6NuZmCusdM.jpg?size=100x100&quality=96&sign=a12ba6f19b94712454afac961ce93e1f&type=album">

2. An example for cameras saw surveillance. Comparison sector definition.

First image\
<img src="https://sun9-35.userapi.com/impg/eEozP8dYRToQHYYGqNHjNkuGJOVSGaDi-M4zfA/jLZ0DI2lTEw.jpg?size=625x351&quality=96&sign=36b1686e3118a602507154b768280954&type=album">\
Second image\
<img src="https://sun9-38.userapi.com/impg/w32LFKreFezapSDAmcv4oGSWB5f-533_uujCEg/qzo3Jipp8N0.jpg?size=625x351&quality=96&sign=dc2e713ca6a5722b070e7e98e5dc6830&type=album">

```php
<?php

require __DIR__ . '/vendor/autoload.php';

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
```
Print result:
```bash
Count all pixels: 219375
Count error pixels: 6455
Error percentage: 2.9424501424501%
```

Result image compares\
<img src="https://sun9-17.userapi.com/impg/ImyWCRFbJmS7JPY5oA5SAk5PoYVmQksubbF4SQ/D5W92MkYwvU.jpg?size=625x351&quality=96&sign=07b23acc5f0e65c0c48c462e4210b327&type=album">