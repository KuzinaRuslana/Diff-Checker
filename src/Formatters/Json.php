<?php

namespace Differ\Formatters\Json;

function makeJson(array $diff): string
{
    $result = json_encode($diff);

    return "{$result}\n";
}
