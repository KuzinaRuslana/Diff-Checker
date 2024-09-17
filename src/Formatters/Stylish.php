<?php

namespace Php\Project\Formatters\Stylish;

function runBuild(array $dataFileOne, array $dataFileTwo): string
{
    $difference = buildStylish($dataFileOne, $dataFileTwo);

    return $difference;
}

function buildStylish(array $dataFileOne, array $dataFileTwo): string
{
    $keys = array_unique(array_merge(array_keys($dataFileOne), array_keys($dataFileTwo)));
    sort($keys);
    $difference = [];

    $difference = array_reduce($keys, function ($acc, $key) use ($dataFileOne, $dataFileTwo) {
        $valueOne = $dataFileOne[$key] ?? null;
        $valueTwo = $dataFileTwo[$key] ?? null;

        $valueOne = is_bool($valueOne) ? ($valueOne ? 'true' : 'false') : $valueOne;
        $valueTwo = is_bool($valueTwo) ? ($valueTwo ? 'true' : 'false') : $valueTwo;

        if (!array_key_exists($key, $dataFileOne)) {
            $acc[] = " + {$key}: {$valueTwo}";
        } elseif (!array_key_exists($key, $dataFileTwo)) {
            $acc[] = " - {$key}: {$valueOne}";
        } elseif ($valueOne !== $valueTwo) {
            $acc[] = " - {$key}: {$valueOne}";
            $acc[] = " + {$key}: {$valueTwo}";
        } else {
            $acc[] = "   {$key}: {$valueOne}";
        }

        return $acc;
    }, []);

    $result = implode("\n", $difference);

    return "{\n{$result}\n}\n";
}
