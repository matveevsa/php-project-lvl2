<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;
use Gendiff;

class GendiffTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testGendiff($format, $ext)
    {
        $pathToFile1 = realpath(__DIR__ . '/fixtures' . "/before.{$ext}");
        $pathToFile2 = realpath(__DIR__ . '/fixtures' . "/after.{$ext}");

        $pathToResult = realpath(__DIR__ . '/fixtures' . "/{$format}Result.txt");

        $expected = file_get_contents($pathToResult);

        $actual = Gendiff\generateDiff($pathToFile1, $pathToFile2, $format);

        $this->assertEquals($expected, $actual);
    }

    public function additionProvider()
    {
        return [
            ['tree', 'json'],
            ['plain', 'yaml'],
            ['json', 'json']
        ];
    }
}
