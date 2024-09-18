<?php

namespace Php\Project\Differ;

use function Php\Project\Parser\parseFile;
use function Php\Project\Formatters\Stylish\runBuildStylish;

function genDiff(string $pathToFileOne, string $pathToFileTwo): string
{
    $dataFileOne = parseFile($pathToFileOne);
    $dataFileTwo = parseFile($pathToFileTwo);

    $difference = runBuildStylish($dataFileOne, $dataFileTwo);

    return $difference;
}
