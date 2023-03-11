<?php

namespace Differ\Differ;

use function Differ\Parsers\parserFile;
use function Differ\Builder\recursArrPlusMinus;
use function Differ\Formatterfabric\formatterFabric;

function genDiff(
    string $firstFile,
    string $secondFile,
    string $format = "stylish"
) {
    $arrFirstFile = parserFile($firstFile);
    $arrSecondFile = parserFile($secondFile);
    $result = recursArrPlusMinus($arrFirstFile, $arrSecondFile);
    $res = formatterFabric($result, $format);
    return $res;
}
