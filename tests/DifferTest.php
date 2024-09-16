<?php

namespace Php\Project\Tests;

use PHPUnit\Framework\TestCase;
use function Php\Project\Differ\genDiff;

class DifferTest extends TestCase {
    public function getFixtureFullPath($fixtureName): bool|string
    {
        $parts = [__DIR__, 'fixtures', $fixtureName];

        return realpath(implode('/', $parts));
    }

    public function testFlatJson(): void
    {
        $pathToResult = $this->getFixtureFullPath('stylish-expected.txt');
        $expected = file_get_contents($pathToResult);
        $actual = genDiff($this->getFixtureFullPath('file1.json'), $this->getFixtureFullPath('file2.json'));
        $this->assertEquals($expected, $actual);
    }
}
