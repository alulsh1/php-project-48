<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parserFile(string $filePath)
{
    $str = file_get_contents($filePath, false, null, 0);
    if ($str !== false) {
        if (pathinfo($filePath, PATHINFO_EXTENSION) === 'json') {
            $array = json_decode($str, true);
        } else {
            $array = Yaml::parse($str);
        }
        return $array;
    }
}
