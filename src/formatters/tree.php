<?php

namespace GenDiff\Formatter\tree;

function repeatSpace($count = 0)
{
    return str_repeat(' ', $count);
}

function stringify($item, $count = 0)
{
    if (!is_array($item)) {
        return $item;
    }

    $keys = array_keys($item);

    $parts = array_map(fn($key) => "{$key}: {$item[$key]}", $keys);

    return "{" . PHP_EOL
        . repeatSpace($count + 4)
        . implode("\n", $parts) . PHP_EOL
        . repeatSpace($count) . "}";
}

function stringifyTree($ast, $depth = 1)
{
    $templates = [
        'deleted' => fn($item, $depth) => repeatSpace($depth * 4 - 2)
            . "- {$item['key']}: "
            . stringify($item['value'], $depth * 4),

        'added' => fn($item, $depth) => repeatSpace($depth * 4 - 2)
            . "+ {$item['key']}: "
            . stringify($item['value'], $depth * 4),

        'unchanged' => fn($item, $depth) => repeatSpace($depth * 4)
            . "{$item['key']}: "
            . stringify($item['value'], $depth * 4),

        'changed' => fn($item, $depth) => repeatSpace($depth * 4 - 2)
            . "+ {$item['key']}: "
            . stringify($item['value']) . PHP_EOL .
            repeatSpace($depth * 4 - 2)
            . "- {$item['key']}: "
            . stringify($item['oldValue'], $depth),

        'hasChildren' => fn($item, $depth) => repeatSpace($depth * 4) .
            "{$item['key']}: {\n" . stringifyTree($item['children'], $depth + 1)
            . PHP_EOL . repeatSpace($depth * 4) . "}"
    ];

    $parts = array_map(function ($item) use ($templates, $depth) {
        if ($item['value'] === true) {
            $item['value'] = 'true';
        } elseif ($item['value'] === false) {
            $item['value'] = 'false';
        }
        return $templates[$item['status']]($item, $depth);
    }, $ast);

    $result = implode("\n", $parts);

    return $result;
}

function toStringTree($ast)
{
    return "{\n" . stringifyTree($ast) . "\n}" . PHP_EOL;
}
