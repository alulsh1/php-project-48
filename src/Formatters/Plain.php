<?php

namespace Differ\Formatters\Plain;

use function Functional\flatten;

function toString(mixed $value)
{
    if ($value === null) {
        return "null";
    } elseif ($value === false) {
        return "false";
    } elseif ($value === true) {
        return "true";
    } elseif (is_numeric($value)) {
        return $value;
    } elseif (is_array($value)) {
        return "[complex value]";
    }
    $res = trim(var_export($value, true), "'");
    return "'{$res}'";
}

function iter(array $arr, string $path = "")
{
    $result = array_map(
        function ($key, $value) use ($arr, $path) {
            $sim = substr($key, 0, 2);
            $property = substr($key, 2);
            $sim2 = $sim === "+ " ? "- " : "+ ";
            $fullPath = $path . "." . $property;
            $ph = substr($fullPath, 1);
            if ($sim == "  " && is_array($value)) {
                return iter($value, $fullPath);
            } elseif (
                isset($sim2) &&
                array_key_exists($sim2 . $property, $arr)
            ) {
                $minus = toString($arr["- " . $property]);
                $plus = toString($arr["+ " . $property]);
                return "Property '{$ph}' was updated. From {$minus} to {$plus}";
            } elseif (isset($arr["+ " . $property])) {
                $plus = toString($arr["+ " . $property]);
                return "Property '{$ph}' was added with value: {$plus}";
            } elseif (isset($arr["- " . $property])) {
                return "Property '{$ph}' was removed";
            }
        },
        array_keys($arr),
        array_values($arr)
    );

    return $result;
}

function plain(array $arr)
{
    $res = iter($arr);
    $flattened = flatten($res);
    $array = array_diff($flattened, [""]);
    return implode("\n", array_unique($array));
}
