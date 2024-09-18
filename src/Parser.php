<?php

namespace Php\Project\Parser;

use Symfony\Component\Yaml\Yaml;

function getContent($pathToFile): array
{
    return ['dataFormat' => getFileFormat($pathToFile), 'dataContent' => file_get_contents($pathToFile)];
}

function getFileFormat($pathToFile): string
{
    return pathInfo($pathToFile, PATHINFO_EXTENSION);
}

function parseFile(string $pathToFile): array
{
    $fileContent = getContent($pathToFile);
    $fileExtension = $fileContent['dataFormat'];
    $fileData = $fileContent['dataContent'];

    $result = match ($fileExtension) {
        'json' => json_decode($fileData, true),
        'yml', 'yaml' => Yaml::parse($fileData),
        default => 'The format is not supported.'
    };

    return $result;
}
