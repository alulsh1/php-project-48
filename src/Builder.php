<?php

namespace Differ\Builder;

function arrSort(array &$arr)
{
    ksort($arr);
    foreach ($arr as $k => &$v) {
        if (is_array($v)) {
            arrSort($v);
        }
    }
}

function madeProbrlArrKeys(array $arr)
{

    $formatted_attribs = array_reduce(
        array_keys($arr),
        function ($carry, $key) use ($arr) {
            $sim = substr($key, 0, 2);
            if ($sim == '+ ' || $sim == '- ' || $sim == '  ') {
                $carry[$key] = is_array($arr[$key]) ? madeProbrlArrKeys($arr[$key]) : $arr[$key];
                return $carry;
            } else {
                $carry['  ' . $key] = is_array($arr[$key]) ? madeProbrlArrKeys($arr[$key]) : $arr[$key];
                return $carry;
            }
        },
        []
    );
    return $formatted_attribs;
}


function recursArrPlusMinus(array $arrFirst, array $arrSecond)
{
    $arr2 = [];
    $arr = array_replace_recursive($arrFirst, $arrSecond);
    arrSort($arr);
    foreach ($arr as $key => $item) {
        if (array_key_exists($key, $arrFirst) && array_key_exists($key, $arrSecond)) {
            if (is_array($item)) {
                $arr2['  ' . $key] = recursArrPlusMinus($arrFirst[$key], $arrSecond[$key]);
            } else {
                if ($arrFirst[$key] === $arrSecond[$key]) {
                    $arr2['  ' . $key] = $item;
                } elseif ($arrFirst[$key] !== $arrSecond[$key]) {
                    $arr2['- ' . $key] = $arrFirst[$key];
                    $arr2['+ ' . $key] = $arrSecond[$key];
                }
            }
        } elseif (array_key_exists($key, $arrFirst)) {
            $arr2['- ' . $key] = $arrFirst[$key];
        } else {
            $arr2['+ ' . $key] = $arrSecond[$key];
        }
    }
    return madeProbrlArrKeys($arr2);
}
