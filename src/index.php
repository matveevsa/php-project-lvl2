<?php

namespace GenDiff;

use function GenDiff\Formatters\toString;
use function GenDiff\generateAst\generateAst;
use function GenDiff\parse\parse;

function generateDiff($pathToFile1, $pathToFile2, $format = 'tree')
{
    $realPath1 = realpath($pathToFile1);
    $realPath2 = realpath($pathToFile2);

    $contentFile1 = file_get_contents($realPath1);
    $contentFile2 = file_get_contents($realPath2);

    $extFile1 = pathinfo($realPath1, PATHINFO_EXTENSION);
    $extFile2 = pathinfo($realPath2, PATHINFO_EXTENSION);

    $dataFile1 = parse($contentFile1, $extFile1);
    $dataFile2 = parse($contentFile2, $extFile2);
    $ast = generateAst($dataFile1, $dataFile2);

    return toString($ast, $format);
}
