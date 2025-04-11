<?php

namespace Differ\InfoExtractor;

function getContent(string $pathToFile): string|false
{
    if (file_exists($pathToFile)) {
        return file_get_contents($pathToFile);
    } else {
        throw new \Exception("Invalid file path: {$pathToFile}");
    }
}

function getFormat(string $pathToFile): string
{
    return pathinfo($pathToFile, PATHINFO_EXTENSION);
}
