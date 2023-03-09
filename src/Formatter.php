<?php

namespace Differ\Formatter;

function toString($value)
{
    return trim(var_export($value, true), "'");
}

// BEGIN (write your solution here)

function res($element, $simvol = ' ', $col = 1, $deph = 1)
{
    $res = '';
    $accessSimvol = str_repeat($simvol, $deph * $col - 2);
    $bracketIndent = str_repeat($simvol, $deph * $col);
    foreach ($element as $key => $item) {
        if (!is_array($item)) {
            $res .= $accessSimvol . toString($key) . ": " . toString($item) . "\n";
        } else {
            $res .= $accessSimvol . $key . ": {\n" . res($item, $simvol, $col, $deph + 1)
            . $bracketIndent . "}\n";
        }
    }
    return $res;
}

function format($data, $simvol = ' ', $col = 1)
{
    if (is_array($data)) {
        return "{\n" . res($data, $simvol, $col) . "}";
    } else {
        return toString($data);
    }
}
