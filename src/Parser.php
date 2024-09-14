<?php

namespace Php\Project\Parser;

function readAndParseJsonFile($filePath): array
{
    $jsonString = file_get_contents($filePath);
    $data = json_decode($jsonString, true);

    return $data;
}
