<?php

namespace Php\Project\Builder;

function buildDiff($dataFileOne, $dataFileTwo)
{
    $keys = array_unique(array_merge(array_keys($dataFileOne), array_keys($dataFileTwo)));
    sort($keys);

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
            return ['status' => 'changed', 'key' => $key, 'oldValue' => $valueOne, 'newValue' => $valueTwo];
        } else {
            return ['status' => 'unchanged', 'key' => $key, 'value' => $valueOne];
        }
    }, $keys);
}
