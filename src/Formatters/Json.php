<?php

namespace Differ\Formatters\Json;

function json(array $arr)
{
    return json_encode($arr, JSON_PRETTY_PRINT);
}
