<?php

namespace Gendiff;

function generateDiff()
{
    $doc = <<<DOC
    Generate diff

    Usage:
      gendiff (-h|--help)
      gendiff (-v|--version)
      gendiff [--format <fmt>] <firstFile> <secondFile>

    Options:
      -h --help                     Show this screen
      -v --version                  Show version
      --format <fmt>                Report format [default: pretty]

    DOC;

    $args = \Docopt::handle($doc);

    $path1 = realpath($args['<firstFile>']);
    $path2 = realpath($args['<secondFile>']);

    print_r(file_get_contents($path1) . PHP_EOL);
}
