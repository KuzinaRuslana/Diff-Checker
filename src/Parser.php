<?php

namespace Php\Project\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $pathToFile): array
{
    $fileContent = getContent($pathToFile);
    $fileExtension = $fileContent['dataFormat'];
    $fileData = $fileContent['dataContent'];

    return match ($fileExtension) {
        'json' => json_decode($fileData, true),
        'yml', 'yaml' => Yaml::parse($fileData),
        default => throw new \Exception("The file's format '$fileExtension' is not supported."),
    };
}

function getContent(string $pathToFile): array
{
    return ['dataFormat' => getFileFormat($pathToFile), 'dataContent' => file_get_contents($pathToFile)];
}

function getFileFormat(string $pathToFile): string
{
    return pathInfo($pathToFile, PATHINFO_EXTENSION);
}
