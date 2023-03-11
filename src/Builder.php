<?php

namespace Differ\Builder;

use Functional;

/*
function arrSort(array &$arr)
{
    ksort($arr);
    foreach ($arr as $k => &$v) {
        if (is_array($v)) {
            arrSort($v);
        }
    }
}
*/
/*
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
*/

function probel(array $arr)
{
    $iter = array_map(
        function ($key, $value) {
            $sim = substr($key, 0, 2);
            if ($sim == "+ " || $sim == "- " || $sim == "  ") {
                if (is_array($value)) {
                    return [$key => probel($value)];
                } else {
                    return [$key => $value];
                }
            } else {
                if (is_array($value)) {
                    return ["  " . $key => probel($value)];
                } else {
                    return ["  " . $key => $value];
                }
            }
        },
        array_keys($arr),
        $arr
    );

    return array_merge(...$iter);
}

function recursArrPlusMinus1(array $arrFirst, array $arrSecond)
{
    $keys = Functional\sort(
        array_unique(
            array_merge(array_keys($arrFirst), array_keys($arrSecond))
        ),
        function ($key, $key2) {
            return $key <=> $key2;
        }
    );

    $tree = array_map(function ($key) use ($arrFirst, $arrSecond) {
        if (
            array_key_exists($key, $arrFirst) &&
            array_key_exists($key, $arrSecond)
        ) {
            if (is_array($arrFirst[$key]) && is_array($arrSecond[$key])) {
                return [
                    "  " . $key => recursArrPlusMinus(
                        $arrFirst[$key],
                        $arrSecond[$key]
                    ),
                ];
            } else {
                if ($arrFirst[$key] === $arrSecond[$key]) {
                    return ["  " . $key => $arrSecond[$key]];
                } elseif ($arrFirst[$key] !== $arrSecond[$key]) {
                    return [
                        "- " . $key => $arrFirst[$key],
                        "+ " . $key => $arrSecond[$key],
                    ];
                }
            }
        } elseif (array_key_exists($key, $arrFirst)) {
            return ["- " . $key => $arrFirst[$key]];
        } else {
            return ["+ " . $key => $arrSecond[$key]];
        }
    }, $keys);

    return array_merge(...$tree);

    /*
    $arr2 = [];
    $arr = array_replace_recursive($arrFirst, $arrSecond);
    arrSort($arr);
    foreach ($arr as $key => $item) {
        if (array_key_exists($key, $arrFirst) && array_key_exists($key, $arrSecond)) {
            if (is_array($item) && is_array($arrFirst[$key]) && is_array($arrSecond[$key])) {
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
    return madeProbrlArrKeys($arr2);*/
}

function recursArrPlusMinus(array $arrFirst, array $arrSecond)
{
    return probel(recursArrPlusMinus1($arrFirst, $arrSecond));
}
