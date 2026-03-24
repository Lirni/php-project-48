<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\Differ\genDiff;

class DifferTest extends TestCase
{
    private function getFixturePath(string $name): string
    {
        return __DIR__ . "/fixtures/" . $name;
    }

    public function testGenDiff(): void
    {
        $path1 = $this->getFixturePath('file1.json');
        $path2 = $this->getFixturePath('file2.json');
        $expected = file_get_contents($this->getFixturePath('expected_stylish.txt'));
        $this->assertEquals(trim($expected), trim(genDiff($path1, $path2)));
    }
    public function testGenDiffJson(): void
    {
        $path1 = $this->getFixturePath('file1.json');
        $path2 = $this->getFixturePath('file2.json');
        $expected = file_get_contents($this->getFixturePath('expected_stylish.txt'));
        $this->assertEquals(trim($expected), trim(genDiff($path1, $path2)));
    }

    public function testGenDiffYaml(): void
    {
        $path1 = __DIR__ . "/fixtures/file1.yml";
        $path2 = __DIR__ . "/fixtures/file2.yml";
        $expected = file_get_contents(__DIR__ . "/fixtures/expected_stylish.txt");
        $normalizedExpected = str_replace("\r\n", "\n", $expected);

        $this->assertEquals(trim($normalizedExpected), trim(genDiff($path1, $path2)));
    }
}
