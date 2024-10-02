<?php

namespace Differ\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $fileContent, string $fileExtension): array
{
    return match ($fileExtension) {
        'json' => json_decode($fileContent, true),
        'yml', 'yaml' => Yaml::parse($fileContent),
        default => throw new \Exception("The file's format '{$fileExtension}' is not supported."),
    };
}
