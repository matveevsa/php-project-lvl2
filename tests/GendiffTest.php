<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;
use Gendiff;

class GendiffTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */

    public function testGendiff($result, $ext)
    {
        $pathToFile1 = realpath(__DIR__ . '/fixtures' . "/before.{$ext}");
        $pathToFile2 = realpath(__DIR__ . '/fixtures' . "/after.{$ext}");

        $pathToResult = realpath(__DIR__ . '/fixtures' . "/{$result}.txt");

        $expected = file_get_contents($pathToResult);

        $actual = Gendiff\generateDiff($pathToFile1, $pathToFile2);

        $this->assertEquals($expected, $actual);
    }

    public function additionProvider()
    {
        return [
            ['result', 'json'],
            ['result', 'yaml'],
        ];
    }
}
