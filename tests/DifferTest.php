<?php

namespace Php\Project\Tests;

use PHPUnit\Framework\TestCase;
use function Php\Project\Differ\genDiff;

class DifferTest extends TestCase
{
    private $formats;
    public function setUp(): void
    {
        $this->formats = [
            'json' => ['file1' => 'file1.json', 'file2' => 'file2.json'],
            'yaml' => ['file1' => 'file1.yaml', 'file2' => 'file2.yaml'],
            'yml' => ['file1' => 'file1.yml', 'file2' => 'file2.yml'],
        ];
    }

    public function getFixtureFullPath($fixtureName): bool|string
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];

        return realpath(implode('/', $parts));
    }

    public function testMakeStylish(): void
    {
        foreach ($this->formats as $format => $files) {
            $pathToResult = $this->getFixtureFullPath('stylish-expected.txt');
            $expected = file_get_contents($pathToResult);
            $actual = genDiff($this->getFixtureFullPath($files['file1']), $this->getFixtureFullPath($files['file2']));
            $this->assertEquals($expected, $actual);
        }
    }

    public function testMakePlain(): void
    {
        foreach ($this->formats as $format => $files) {
            $pathToResult = $this->getFixtureFullPath('plain-expected.txt');
            $expected = file_get_contents($pathToResult);
            $actual = genDiff($this->getFixtureFullPath($files['file1']), $this->getFixtureFullPath($files['file2']), 'plain');
            $this->assertEquals($expected, $actual);
        }
    }

    public function testMakeJson(): void
    {
        foreach ($this->formats as $format => $files) {
            $pathToResult = $this->getFixtureFullPath('json-expected.txt');
            $expected = file_get_contents($pathToResult);
            $actual = genDiff($this->getFixtureFullPath($files['file1']), $this->getFixtureFullPath($files['file2']), 'json');
            $this->assertEquals($expected, $actual);
        }
    }
}
