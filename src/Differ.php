<?php

namespace Differ\Differ;

use function Differ\Parsers\parserFile;
use function Differ\Formatter\format;
use function Differ\Builder\recursArrPlusMinus;

function gendiff($firstFile, $secondFile, $format)
{
    $arrFirstFile = parserFile($firstFile);
    $arrSecondFile = parserFile($secondFile);
    $result = recursArrPlusMinus($arrFirstFile, $arrSecondFile);

    print_r(format($result, ' ', 4));

    return format($result, ' ', 4);
}
