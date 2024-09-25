<?php

namespace Php\Project\Differ;

use function Php\Project\Parser\parseFile;
use function Php\Project\Builder\buildDiff;
use function Php\Project\Formatter\getFormattedDiff;

function genDiff(string $pathToFileOne, string $pathToFileTwo, string $format = 'stylish'): string
{
    $dataFileOne = parseFile($pathToFileOne);
    $dataFileTwo = parseFile($pathToFileTwo);

    $diff = buildDiff($dataFileOne, $dataFileTwo);

    return getFormattedDiff($diff, $format);
}
