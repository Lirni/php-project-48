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

    public function testGenDiffDefault(): void
    {
        $path1 = $this->getFixturePath('file1.json');
        $path2 = $this->getFixturePath('file2.json');
        $expected = (string) file_get_contents($this->getFixturePath('expected_stylish.txt'));

        $normalizedExpected = str_replace("\r\n", "\n", $expected);
        $this->assertEquals(trim($normalizedExpected), trim(genDiff($path1, $path2)));
    }

    public function testGenDiffJson(): void
    {
        $path1 = $this->getFixturePath('file1.json');
        $path2 = $this->getFixturePath('file2.json');
        $expected = (string) file_get_contents($this->getFixturePath('expected_stylish.txt'));

        $normalizedExpected = str_replace("\r\n", "\n", $expected);
        $this->assertEquals(trim($normalizedExpected), trim(genDiff($path1, $path2, 'stylish')));
    }

    public function testGenDiffYaml(): void
    {
        $path1 = $this->getFixturePath('file1.yml');
        $path2 = $this->getFixturePath('file2.yml');
        $expected = (string) file_get_contents($this->getFixturePath('expected_stylish.txt'));

        $normalizedExpected = str_replace("\r\n", "\n", $expected);
        $this->assertEquals(trim($normalizedExpected), trim(genDiff($path1, $path2, 'stylish')));
    }

    public function testGenDiffPlain(): void
    {
        $path1 = $this->getFixturePath('file1.json');
        $path2 = $this->getFixturePath('file2.json');
        $expected = (string) file_get_contents($this->getFixturePath('expected_plain.txt'));

        $normalizedExpected = str_replace("\r\n", "\n", $expected);
        $this->assertEquals(trim($normalizedExpected), trim(genDiff($path1, $path2, 'plain')));
    }
}
