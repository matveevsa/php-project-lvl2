<?php

namespace GenDiff\Formatter\plain;

function stringify($item)
{
    return is_array($item) ? 'complex value' : $item;
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
            "Property '" . joinPath($path) . "' was changed. From '{$item['oldValue']}' to '{$item['value']}'"),

        'hasChildren' => fn($path, $item) => stringifyPlain($item['children'], $path)
    ];

    $parts = array_map(function ($item) use ($templates, $path) {
        if ($item['value'] === true) {
            $item['value'] = 'true';
        } elseif ($item['value'] === false) {
            $item['value'] = 'false';
        }
        $path[] = $item['key'];
        return $templates[$item['status']]($path, $item);
    }, $ast);
    $filtered = array_filter($parts, fn($item) => $item !== null);

    $result = implode("\n", $filtered);

    return $result;
}

function toStringPlain($ast)
{
    return stringifyPlain($ast) . PHP_EOL;
}
