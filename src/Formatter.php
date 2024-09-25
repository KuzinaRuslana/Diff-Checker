<?php

namespace Php\Project\Formatter;

use function Php\Project\Formatters\Stylish\makeStylish;

function getFormattedDiff(array $diff, string $format): string
{
    return match ($format) {
        'stylish' => makeStylish($diff),
        default => throw new \Exception("The format '$format' is not supported."),
    };
}
