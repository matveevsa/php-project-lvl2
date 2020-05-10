<?php

namespace GenDiff\Tree;

function repeatDelimeter($delimeter, $count = 0)
{
    return str_repeat($delimeter, $count);
}

function stringify($item, $delimeter = '', $delimeterCountStart = 0, $delimeterCountEnd = 2)
{
    if (!is_array($item)) {
        return $item;
    }

    $keys = array_keys($item);

    $parts = array_map(function ($key) use ($item) {
        return "{$key}: {$item[$key]}";
    }, $keys);

    return "{" . PHP_EOL
        . repeatDelimeter($delimeter, $delimeterCountStart)
        . implode("\n", $parts) . PHP_EOL
        . repeatDelimeter($delimeter, $delimeterCountStart - $delimeterCountEnd)  . "}";
}

function stringifyTree($ast, $depth = 0, $delimeter = ' ', $delimeterCount = 2)
{
    $templates = [
        'deleted' => fn($item) => repeatDelimeter($delimeter, $depth * $delimeterCount + 2)
            . "- " . stringify($item['key'], $delimeter, $delimeterCount) . ": "
            . stringify($item['value'], $delimeter, ($depth + 1) * $delimeterCount + ($depth == 0 ? 6 : 4), 4),

        'added' => fn($item) => repeatDelimeter($delimeter, $depth * $delimeterCount + 2)
            . "+ " . stringify($item['key'], $delimeter, $delimeterCount) . ": "
            . stringify($item['value'], $delimeter, ($depth + 1) * $delimeterCount + ($depth == 0 ? 6 : 4), 4),

        'unchanged' => fn($item) => repeatDelimeter($delimeter, $depth * $delimeterCount + 4)
            . stringify($item['key'], $delimeter, $delimeterCount) . ": "
            . stringify($item['value'], $delimeter, $delimeterCount),

        'changed' => fn($item) => repeatDelimeter($delimeter, $depth * $delimeterCount + 2)
            . "+ " . stringify($item['key'], $delimeter, $delimeterCount) . ": "
            . stringify($item['value']) . PHP_EOL .
            repeatDelimeter($delimeter, $depth * $delimeterCount + 2)
            . "- " . stringify($item['key'], $delimeter, $delimeterCount) . ": "
            . stringify($item['oldValue'], $delimeter, $delimeterCount),

        'hasChildren' => fn($item) => repeatDelimeter($delimeter, $depth * $delimeterCount + 4) .
            "{$item['key']}: {\n" . stringifyTree($item['children'], $depth + 1, $delimeter, $delimeterCount + 2)
            . PHP_EOL . repeatDelimeter($delimeter, $depth * $delimeterCount + 4) . "}"
    ];

    $parts = array_map(function ($item) use ($templates) {
        if ($item['value'] === true) {
            $item['value'] = 'true';
        } elseif ($item['value'] === false) {
            $item['value'] = 'false';
        }
        return $templates[$item['status']]($item);
    }, $ast);

    $result = implode("\n", $parts);

    return $result;
}

function toStringTree($ast)
{
    return "{\n" . stringifyTree($ast) . "\n}";
}
