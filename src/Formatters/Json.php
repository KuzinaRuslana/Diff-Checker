<?php

namespace Php\Project\Formatters\Json;

function makeJson(array $diff): string
{
    return json_encode($diff) . "\n";
}
