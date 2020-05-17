<?php

namespace GenDiff\Formatter\plain;

function stringify($item)
{
    $currentItem = is_array($item) ? 'complex value' : $item;

    if ($currentItem === true) {
        $currentItem = 'true';
    } elseif ($currentItem === false) {
        $currentItem = 'false';
    }

    return $currentItem;
}

function joinPath($path)
{
    return implode('.', $path);
}

function stringifyPlain($ast, $path = [])
{
    $templates = [
        'deleted' => fn($path) => "Property '" . joinPath($path) . "' was removed",

        'unchanged' => fn() => null,

        'added' => fn($path, $item) => ("Property '" . joinPath($path) . "' was added with value: '"
         . stringify($item['value']) . "'"),

        'changed' => fn($path, $item) => (
            "Property '" . joinPath($path)
            . "' was changed. From '" . stringify($item['oldValue'])
            . "' to '" . stringify($item['value']) . "'"),

        'hasChildren' => fn($path, $item) => stringifyPlain($item['children'], $path)
    ];

    $parts = array_map(function ($item) use ($templates, $path) {
        $path[] = $item['key'];
        return $templates[$item['status']]($path, $item);
    }, $ast);

    $filtered = array_filter($parts, fn($item) => $item !== null);

    $result = implode("\n", $filtered);

    return $result;
}

function toStringPlain($ast)
{
    return stringifyPlain($ast) . "\n";
}
