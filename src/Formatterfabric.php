<?php

namespace Differ\Formatterfabric;

use function Differ\Formatters\Stylish\stylish;
use function Differ\Formatters\Plain\plain;
use function Differ\Formatters\Json\json;

function formatterFabric(array $arr, string $format)
{
    $master = [
     'stylish' => fn($arr) => stylish($arr, ' ', 4),
     'plain' => fn($arr) => plain($arr),
     'json' => fn($arr) => json($arr)
    ];
    return $master[$format]($arr);
}
