<?php

namespace Differ\Formatterfabric;

use function Differ\Formatters\Stylish\stylish;
use function Differ\Formatters\Plain\plain;

function formatterFabric($arr, $format)
{
    $master = [
    'stylish' => fn($arr) => stylish($arr, ' ', 4),
    'plain' => fn($arr) => plain($arr)
    ];
    return $master[$format]($arr);
}
