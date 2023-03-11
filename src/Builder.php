<?php

namespace Differ\Builder;

use function Functional\reduce_left;

function arrSort(array &$arr)
{
    ksort($arr);
    foreach ($arr as $k => &$v) {
        if (is_array($v)) {
            arrSort($v);
        }
    }
}

function test($arr)
{
    $str = reduce_left(
        $arr,
        function ($value, $index, $collection, $reduction) {
            $sim = substr($index, 0, 2);
            if ($sim == "+ " || $sim == "- " || $sim == "  ") {
                if (!is_array($value)) {
                    $reduction[$index] = $value;
                } else {
                    $reduction[$index] = test($value);
                }
            } else {
                if (!is_array($value)) {
                    $reduction["  " . $index] = $value;
                } else {
                    $reduction["  " . $index] = test($value);
                }
            }

            return array_merge($reduction);
        },
        []
    );
    return $str;
}

function recursArrPlusMinus(array $arrFirst, array $arrSecond)
{
    $arr2 = [];
    $arr = array_replace_recursive($arrFirst, $arrSecond);
    arrSort($arr);
    foreach ($arr as $key => $item) {
        if (
            array_key_exists($key, $arrFirst) &&
            array_key_exists($key, $arrSecond)
        ) {
            if (
                is_array($item) &&
                is_array($arrFirst[$key]) &&
                is_array($arrSecond[$key])
            ) {
                $arr2["  " . $key] = recursArrPlusMinus(
                    $arrFirst[$key],
                    $arrSecond[$key]
                );
            } else {
                if ($arrFirst[$key] === $arrSecond[$key]) {
                    $arr2["  " . $key] = $item;
                } elseif ($arrFirst[$key] !== $arrSecond[$key]) {
                    $arr2["- " . $key] = $arrFirst[$key];
                    $arr2["+ " . $key] = $arrSecond[$key];
                }
            }
        } elseif (array_key_exists($key, $arrFirst)) {
            $arr2["- " . $key] = $arrFirst[$key];
        } else {
            $arr2["+ " . $key] = $arrSecond[$key];
        }
    }
    return test($arr2);
}
