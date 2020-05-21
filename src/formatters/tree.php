<?php

namespace GenDiff\Formatter\tree;

function repeatSpace($count = 0)
{
    return str_repeat(' ', $count);
}

function stringify($item, $count = 0)
{
    if (!is_array($item)) {
        if (is_bool($item)) {
            $item = $item ? 'true' : 'false';
        }

        return $item;
    }

    $keys = array_keys($item);

    $parts = array_map(fn($key) =>
        repeatSpace($count + 4) . "{$key}: " . stringify($item[$key], $count + 4), $keys);

    return "{\n"
        . implode("\n", $parts) . "\n"
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
            . stringify($item['value']) . "\n" .
            repeatSpace($depth * 4 - 2)
            . "- {$item['key']}: "
            . stringify($item['oldValue'], $depth),

        'hasChildren' => fn($item, $depth) => repeatSpace($depth * 4) .
            "{$item['key']}: {\n" . stringifyTree($item['children'], $depth + 1)
            . "\n" . repeatSpace($depth * 4) . "}"
    ];

    $parts = array_map(fn($item) => $templates[$item['status']]($item, $depth), $ast);

    $result = implode("\n", $parts);

    return $result;
}

function toStringTree($ast)
{
    return "{\n" . stringifyTree($ast) . "\n}\n";
}
