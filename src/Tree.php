<?php

namespace Gendiff\Tree;

function stringifyTree($ast)
{
    $templates = [
        'deleted' => fn($item) => "  - {$item['key']}: {$item['value']}",
        'added' => fn($item) => "  + {$item['key']}: {$item['value']}",
        'unchanged' => fn($item) => "    {$item['key']}: {$item['value']}",
        'changed' => fn($item) => "  + {$item['key']}: {$item['value']}\n  - {$item['key']}: {$item['oldValue']}"
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

    return "{\n{$result}\n}";
}

function renderTree($str)
{
    return $str;
}
