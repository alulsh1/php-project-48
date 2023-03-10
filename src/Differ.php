<?php

namespace Differ\Differ;

use function Differ\Parsers\parserFile;
use function Differ\Formatter\format;
use function Differ\Formatters\Plain\plain;
use function Differ\Builder\recursArrPlusMinus;
use function Differ\Formatterfabric\formatterFabric;
use function Functional\flatten;

function gendiff(string $firstFile, string $secondFile, string $format = 'stylish')
{
    $arrFirstFile = parserFile($firstFile);
    $arrSecondFile = parserFile($secondFile);
    $result = recursArrPlusMinus($arrFirstFile, $arrSecondFile);
    $res = formatterFabric($result, $format);
    return $res;
}
