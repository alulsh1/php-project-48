<?php

namespace Differ\Formatters\Json;

function json($arr)
{
    return json_encode($arr, JSON_PRETTY_PRINT);
}
