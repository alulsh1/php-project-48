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

            $fullPath = $path . "." . $property;
            $ph = substr($fullPath, 1);

            if (array_key_exists("- " . $property, $arr)) {
                $minus = toString($arr["- " . $property]);
            }
            if (array_key_exists("+ " . $property, $arr)) {
                $plus = toString($arr["+ " . $property]);
            }

            if (
                array_key_exists("- " . $property, $arr) &&
                array_key_exists("+ " . $property, $arr)
            ) {
                if (
                    is_array($arr["+ " . $property]) &&
                    is_array($arr["- " . $property])
                ) {
                    return "Property '{$ph}' was updated. From [complex value] to [complex value]";
                } elseif (
                    is_array($arr["+ " . $property]) &&
                    !is_array($arr["- " . $property])
                ) {
                    return  "Property '{$ph}' was updated. From {$minus} to [complex value]";
                } elseif (
                    is_array($arr["- " . $property]) &&
                    !is_array($arr["+ " . $property])
                ) {
                    return   "Property '{$ph}' was updated. From [complex value] to {$plus}";
                } elseif (
                    !is_array($arr["- " . $property]) &&
                    !is_array($arr["+ " . $property])
                ) {
                    return  "Property '{$ph}' was updated. From {$minus} to {$plus}";
                }
            } elseif (isset($arr["+ " . $property])) {
                if (is_array($arr["+ " . $property])) {
                    return  "Property '{$ph}' was added with value: [complex value]";
                } else {
                    return  "Property '{$ph}' was added with value: {$plus}";
                }
            } elseif (isset($arr["- " . $property])) {
                return "Property '{$ph}' was removed";
            } elseif ($sim == "  " && is_array($value)) {
                return iter($value, $fullPath);
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
    $array = array_diff($flattened, array(''));
    return implode("\n", array_unique($array));
}
