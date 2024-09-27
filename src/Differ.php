<?php

namespace Differ\Differ;

use function Differ\Parser\parseFile;
use function Differ\Builder\buildDiff;
use function Differ\Formatter\getFormattedDiff;

function genDiff(string $pathToFileOne, string $pathToFileTwo, string $format = 'stylish'): string
{
    $dataFileOne = parseFile($pathToFileOne);
    $dataFileTwo = parseFile($pathToFileTwo);

    $diff = buildDiff($dataFileOne, $dataFileTwo);

    return getFormattedDiff($diff, $format);
}
