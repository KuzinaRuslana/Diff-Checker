<?php

namespace Php\Project\Formatters\Stylish;

const SPACE_COUNT = 4;
const LEFT_SHIFT = 2;

function makeStylish(array $diff): string
{
    $result = iter($diff);

    return "{\n{$result}\n}";
}

function iter(array $diff, int $depth = 1): string
{
    $indent = str_repeat(' ', $depth * SPACE_COUNT - LEFT_SHIFT);
    $symbols = ['added' => '+', 'deleted' => '-', 'unchanged' => ' '];

    $difference = array_map(function ($item) use ($symbols, $indent, $depth) {
        $key = $item['key'];
        $value = isset($item['value']) ? stringify($item['value'], $depth + 1) : null;

        if ($item['status'] === 'nested') {
            $children = iter($item['value'], $depth + 1);
            return "{$indent}  {$key}: {\n{$children}\n{$indent}  }";
        }

        if ($item['status'] === 'added') {
            return "{$indent}{$symbols['added']} {$key}: {$value}";
        } elseif ($item['status'] === 'deleted') {
            return "{$indent}{$symbols['deleted']} {$key}: {$value}";
        } elseif ($item['status'] === 'changed') {
            $oldValue = stringify($item['oldValue'], $depth + 1);
            $newValue = stringify($item['newValue'], $depth + 1);
            $deletedString = "{$indent}{$symbols['deleted']} {$key}: {$oldValue}";
            $addedString = "{$indent}{$symbols['added']} {$key}: {$newValue}";

            return "{$deletedString}\n{$addedString}";
        }

        return "{$indent}{$symbols['unchanged']} {$key}: {$value}";
    }, $diff);

    return implode("\n", $difference);
}

function stringify($value, int $depth = 1): string
{
    if ($value === null) {
        return "null";
    }
    if (is_bool($value)) {
        return $value ? "true" : "false";
    }

    if (!is_array($value)) {
        return (string) $value;
    }

    $indent = str_repeat(' ', $depth * SPACE_COUNT);
    $bracketIndent = str_repeat(' ', ($depth - 1) * SPACE_COUNT);
    $keys = array_keys($value);

    $array = array_map(function ($key) use ($value, $depth, $indent) {
        $formattedValue = stringify($value[$key], $depth + 1);
        return "{$indent}{$key}: {$formattedValue}";
    }, $keys);

    $string = implode("\n", $array);

    return "{\n{$string}\n{$bracketIndent}}";
}
