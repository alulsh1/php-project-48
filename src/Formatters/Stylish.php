<?php

namespace Differ\Formatters\Stylish;

function toString(mixed $value)
{
    if ($value === null) {
        return 'null';
    }
    return trim(var_export($value, true), "'");
}

// BEGIN (write your solution here)

function stylish($value, string $replacer = ' ', int $spacesCount = 1): string
{
    $iter = function ($currentValue, $depth) use (&$iter, $replacer, $spacesCount) {
        if (!is_array($currentValue)) {
            return toString($currentValue);
        }

        $indentSize = $depth * $spacesCount;
        $currentIndent = str_repeat($replacer, $indentSize -2);
        $bracketIndent = str_repeat($replacer, $indentSize - $spacesCount);

        $lines = array_map(
            fn($key, $val) => "{$currentIndent}{$key}: {$iter($val, $depth + 1)}",
            array_keys($currentValue),
            $currentValue
        );

        $result = ['{', ...$lines, "{$bracketIndent}}"];

        return implode("\n", $result);
    };

    return $iter($value, 1);
}
