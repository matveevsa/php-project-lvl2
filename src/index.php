<?php

namespace Gendiff;

use function Gendiff\Ast\generateAST;
use function Gendiff\Tree\stringifyTree;

function generateDiff($pathToFile1, $pathToFile2)
{
    $dataFile1 = file_get_contents($pathToFile1);
    $dataFile2 = file_get_contents($pathToFile2);

    $ast = generateAST($dataFile1, $dataFile2);
    return stringifyTree($ast);
}
