<?php

namespace GenDiff\Formatters;

use function GenDiff\Formatter\plain\toStringPlain;
use function GenDiff\Formatter\tree\toStringTree;

function toString($ast, $format)
{
    switch ($format) {
        case 'tree':
            return toStringTree($ast);
        case 'plain':
            return toStringPlain($ast);
        case 'json':
            return json_encode($ast);
        default:
            return "Error! Format {$format} is not supported!";
    }
}
