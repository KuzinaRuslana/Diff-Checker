<?php

namespace Differ\Builder;

use function Functional\sort as func_sort;

function buildDiff(array $dataFileOne, array $dataFileTwo): array
{
    $keys = array_unique(array_merge(array_keys($dataFileOne), array_keys($dataFileTwo)));
    $sortedKeys = func_sort($keys, fn($left, $right) => strcmp($left, $right));

    return array_map(function ($key) use ($dataFileOne, $dataFileTwo) {
        $valueOne = $dataFileOne[$key] ?? null;
        $valueTwo = $dataFileTwo[$key] ?? null;

        if (is_array($valueOne) && is_array($valueTwo)) {
            return ['status' => 'nested', 'key' => $key, 'value' => buildDiff($valueOne, $valueTwo)];
        }

        if (!array_key_exists($key, $dataFileOne)) {
            return ['status' => 'added', 'key' => $key, 'value' => $valueTwo];
        } elseif (!array_key_exists($key, $dataFileTwo)) {
            return ['status' => 'deleted', 'key' => $key, 'value' => $valueOne];
        } elseif ($valueOne !== $valueTwo) {
            return ['status' => 'changed', 'key' => $key, 'valueOne' => $valueOne, 'valueTwo' => $valueTwo];
        } else {
            return ['status' => 'unchanged', 'key' => $key, 'value' => $valueOne];
        }
    }, $sortedKeys);
}
