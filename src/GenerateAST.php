<?php

namespace GenDiff\Ast;

use function Funct\Collection\union;

function generateAST($firstData, $secondData)
{
    $keysData1 = array_keys($firstData);
    $keysData2 = array_keys($secondData);
    $keysUnion = union($keysData1, $keysData2);

    foreach ($keysUnion as $key) {
        $item = [
            'key' => $key,
            'value' => null,
            'oldValue' => null,
            'status' => null,
            'children' => []
        ];

        if (array_key_exists($key, $firstData) && !array_key_exists($key, $secondData)) {
            $ast[] = array_merge(
                $item,
                [
                    'status' => "deleted",
                    'value' => $firstData[$key],
                ]
            );
        } elseif (!array_key_exists($key, $firstData) && array_key_exists($key, $secondData)) {
            $ast[] = array_merge(
                $item,
                [
                    'status' => "added",
                    'value' => $secondData[$key],
                ]
            );
        } elseif (is_array($firstData[$key]) && is_array($secondData[$key])) {
            $ast[] = array_merge(
                $item,
                [
                    'status' => 'hasChildren',
                    'children' => generateAST($firstData[$key], $secondData[$key])
                ]
            );
        } elseif ($firstData[$key] !== $secondData[$key]) {
            $ast[] = array_merge(
                $item,
                [
                    'status' => "changed",
                    'value' => $secondData[$key],
                    'oldValue' => $firstData[$key],
                ]
            );
        } elseif ($firstData[$key] === $secondData[$key]) {
            $ast[] = array_merge(
                $item,
                [
                    'status' => "unchanged",
                    'value' => $firstData[$key]
                ]
            );
        }
    }

    return $ast;
}
