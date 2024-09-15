<?php

namespace Php\Project\Parser;

function readFile($file): string
{
    $fileToString = file_get_contents($file);

    return $fileToString;
}

function parseFile(string $file): array
{
    $fileToString = readFile($file);
    $data = json_decode($fileToString, true);

    return $data;
}
