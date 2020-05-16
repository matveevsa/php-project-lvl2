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
        $pathToFile1 = $this->getFixturePath("before.{$ext}");
        $pathToFile2 = $this->getFixturePath("after.{$ext}");

        $pathToResult = $this->getFixturePath("{$format}Result.txt");

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

    private function getFixturePath($filename)
    {
        return realpath(__DIR__ . '/fixtures//' . $filename);
    }
}
