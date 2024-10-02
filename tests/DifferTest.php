<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function getFixtureFullPath($fixtureName): string
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];

        return realpath(implode('/', $parts));
    }

    /**
     * @dataProvider provideTestData
     */
    public function testGenDiff(string $fileOne, string $fileTwo, string $formatter): void
    {
        $expectedFile = $this->getFixtureFullPath("{$formatter}-expected.txt");
        $actual = genDiff($this->getFixtureFullPath($fileOne), $this->getFixtureFullPath($fileTwo), $formatter);
        $this->assertStringEqualsFile($expectedFile, $actual);
    }

    public static function provideTestData(): array
    {    
        return [
            'json and json to stylish' => ['file1.json', 'file2.json', 'stylish'],
            'yaml and yaml to plain' => ['file1.yaml', 'file2.yaml', 'plain'],
            'yml and yml to json' => ['file1.yml', 'file2.yml', 'json'],
            'json and yaml to stylish' => ['file1.json', 'file2.yaml', 'stylish'],
            'yaml and yml to plain' => ['file1.yaml', 'file2.yml', 'plain'],
            'yml and json to json' => ['file1.yml', 'file2.json', 'json']
        ];
    }
}
