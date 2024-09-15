<?php

namespace Php\Project\Differ;

use Php\Project\Parser\parseFile;

use function Php\Project\Parser\parseFile;
use function Php\Project\Formatters\Stylish\buildStylish;

function genDiff(string $pathToFileOne, string $pathToFileTwo): string
{
    $dataFileOne = parseFile($pathToFileOne);
    $dataFileTwo = parseFile($pathToFileTwo);

    $difference = buildStylish($dataFileOne, $dataFileTwo);

    return $difference;
}
