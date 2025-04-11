<?php

namespace Differ\InfoExtractor;

function getContent(string $pathToFile): string
{
    if (!file_exists($pathToFile)) {
        throw new \Exception("Invalid file path: {$pathToFile}");
    }

    $content = file_get_contents($pathToFile);
    if ($content === false) {
        throw new \Exception("Unable to read file: {$pathToFile}");
    }

    return $content;
}

function getFormat(string $pathToFile): string
{
    return pathinfo($pathToFile, PATHINFO_EXTENSION);
}
