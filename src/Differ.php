<?php

namespace Differ\Differ;

use function Differ\InfoExtractor\getContent;
use function Differ\InfoExtractor\getFormat;
use function Differ\Parser\parseFile;
use function Differ\Builder\buildDiff;
use function Differ\Formatter\getFormattedDiff;

function genDiff(string|false $pathToFileOne, string|false $pathToFileTwo, string $format = 'stylish'): string
{
    $firstFileContent = getContent($pathToFileOne);
    $secondFileContent = getContent($pathToFileTwo);

    $firstFileExtension = getFormat($pathToFileOne);
    $secondFileExtension = getFormat($pathToFileTwo);

    $parsedFileOne = parseFile($firstFileContent, $firstFileExtension);
    $parsedFileTwo = parseFile($secondFileContent, $secondFileExtension);

    $diff = buildDiff($parsedFileOne, $parsedFileTwo);

    return getFormattedDiff($diff, $format);
}
