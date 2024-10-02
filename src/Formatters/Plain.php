<?php

namespace Differ\Formatters\Plain;

function makePlain(array $diff): string
{
    $result = iter($diff);

    return "{$result}\n";
}

function iter(array $diff, string $path = ''): string
{
    $filteredData = array_filter($diff, fn($item) => $item['status'] !== 'unchanged');

    $difference = array_map(function ($item) use ($path) {
        $status = $item['status'];
        $currentPath = $path === '' ? $item['key'] : "{$path}.{$item['key']}";

        switch ($status) {
            case 'nested':
                return iter($item['value'], $currentPath);
            case 'added':
                $name = addQuotes($currentPath);
                $value = getPropertyValue($item['value']);
                return "Property {$name} was added with value: {$value}";
            case 'deleted':
                $name = addQuotes($currentPath);
                return "Property {$name} was removed";
            case 'changed':
                $name = addQuotes($currentPath);
                $valueOne = getPropertyValue($item['valueOne']);
                $valueTwo = getPropertyValue($item['valueTwo']);
                return "Property {$name} was updated. From {$valueOne} to {$valueTwo}";
            default:
                throw new \Exception("Unknown status: {$status}");
        }
    }, $filteredData);

    return implode("\n", $difference);
}

function addQuotes(string $path): string
{
    return "'{$path}'";
}

function getPropertyValue(mixed $value): string
{
    if ($value === null) {
        return 'null';
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_string($value)) {
        return "'{$value}'";
    }
    if (!is_array($value)) {
        return (string) $value;
    }

    return '[complex value]';
}
