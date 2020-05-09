<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;
use Gendiff;

class GendiffTest extends TestCase
{
    public function testGendiff()
    {
        $pathToFile1 = realpath(__DIR__ . '/fixtures/before.json');
        $pathToFile2 = realpath(__DIR__ . '/fixtures/after.json');

        $pathToResult = realpath(__DIR__ . '/fixtures/result.txt');

        $expected = file_get_contents($pathToResult);

        $actual = Gendiff\generateDiff($pathToFile1, $pathToFile2);

        $this->assertEquals($expected, $actual);
    }
}
