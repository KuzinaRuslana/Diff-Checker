<?php

namespace Differ\Formatter;

use function Differ\Formatters\Stylish\makeStylish;
use function Differ\Formatters\Plain\makePlain;
use function Differ\Formatters\Json\makeJson;

function getFormattedDiff(array $diff, string $format): string
{
    return match ($format) {
        'stylish' => makeStylish($diff),
        'plain' => makePlain($diff),
        'json' => makeJson($diff),
        default => throw new \Exception("The format '{$format}' is not supported."),
    };
}
