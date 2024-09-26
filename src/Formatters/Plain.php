<?php

namespace Php\Project\Formatters\Plain;

function makePlain(array $diff): string
{
    return iter($diff) . "\n";
}

function iter(array $diff, $path = ''): string
{
    $filteredData = array_filter($diff, fn($item) => $item['status'] !== 'unchanged');

    $difference = array_reduce($filteredData, function ($acc, $item) use ($path) {
        $status = $item['status'];
        $currentPath = $path === '' ? $item['key'] : "{$path}.{$item['key']}";

        switch ($status) {
            case 'nested':
                $acc[] = iter($item['value'], $currentPath);
                break;
            case 'added':
                $name = addQuotes($currentPath);
                $value = getPropertyValue($item['value']);
                $acc[] = "Property {$name} was added with value: {$value}";
                break;
            case 'deleted':
                $name = addQuotes($currentPath);
                $acc[] = "Property {$name} was removed";
                break;
            case 'changed':
                $name = addQuotes($currentPath);
                $valueOne = getPropertyValue($item['oldValue']);
                $valueTwo = getPropertyValue($item['newValue']);
                $acc[] = "Property {$name} was updated. From {$valueOne} to {$valueTwo}";
        }

        return $acc;
    }, []);

    return implode("\n", $difference);
}

function addQuotes(string $path): string
{
    return "'{$path}'";
}

function getPropertyValue(mixed $value): string
{
    if ($value === null) {
        return "null";
    }
    if (is_bool($value)) {
        return $value ? "true" : "false";
    }
    if (is_string($value)) {
        return "'{$value}'";
    }
    if (!is_array($value)) {
        return (string) $value;
    }

    return "[complex value]";
}
