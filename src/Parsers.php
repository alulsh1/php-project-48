<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parserFile(string $filePath)
{
    $mapping = [
        "json" => fn($item) => json_decode($item, true),
        "yml" => fn($item) => Yaml::parse($item),
        "yaml" => fn($item) => Yaml::parse($item),
        "defalt" => fn($item) => "Incorrect way!",
    ];
    $fileContent = file_get_contents($filePath);
    $fileName = pathinfo($filePath)["extension"] ?? "defalt";
    $arr = $mapping[$fileName]($fileContent);
    return $arr;
}
