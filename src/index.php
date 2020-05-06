<?php

namespace Gendiff;

function startGendiff()
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
    print_r($args);
    $path1 = dirname(__FILE__);
    print_r($path1);

}
