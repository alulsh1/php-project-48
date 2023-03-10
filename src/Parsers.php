<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parserFile(string $filePath)
{
    $mapping = [
    'json' => fn($item) => json_decode($item, true),
    'yml' => fn($item) => Yaml::parse($item),
    'yaml' => fn($item) => Yaml::parse($item),
    ];
    $path = dirname(__DIR__, 1) . '/';
    $fileContent = file_get_contents($path . $filePath);
    $fileName = pathinfo($filePath)['extension'];
    $arr = $mapping[$fileName]($fileContent);
    return $arr;
}
