<?php

namespace Differ\Differ;

use function Differ\Parsers\parserFile;

function gendiff($firstFile, $secondFile)
{
    $path = dirname(__DIR__, 1) . '/';

    $arrFirstFile = parserFile($firstFile);
    $arrSecondFile = parserFile($secondFile);

    $arr = [];

    $arr21 = array_merge($arrSecondFile, $arrFirstFile);

    ksort($arr21);

    foreach ($arr21 as $key => $item) {
        if (isset($arrFirstFile[$key]) && isset($arrSecondFile[$key])) {
            if ($arrSecondFile[$key] === $arrFirstFile[$key]) {
                $arr[$key] = $item;
            } else {
                $arr['- ' . $key] = $arrFirstFile[$key];
                $arr['+ ' . $key] = $arrSecondFile[$key];
            }
        } elseif (isset($arrFirstFile[$key])) {
            $arr['- ' . $key] = $arrFirstFile[$key];
        } else {
            $arr['+ ' . $key] = $arrSecondFile[$key];
        }
    }
    $rez = json_encode($arr, JSON_PRETTY_PRINT);
    echo ($rez);
    return json_encode($arr);
}
