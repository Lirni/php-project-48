<?php

namespace Hexlet\Code\Formatters\Stylish;

function stringify(mixed $value, int $depth): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }

    if (!is_array($value) && !is_object($value)) {
        return (string) $value;
    }

    $currentData = is_object($value) ? get_object_vars($value) : $value;

    $keys = array_keys($currentData);
    $indent = str_repeat(" ", ($depth + 1) * 4);
    $closingIndent = str_repeat(" ", $depth * 4);

    $lines = array_map(function ($key) use ($currentData, $depth, $indent) {
        $val = stringify($currentData[$key], $depth + 1);
        return "{$indent}{$key}: {$val}";
    }, $keys);

    $result = implode("\n", $lines);
    return "{\n{$result}\n{$closingIndent}}";
}

function format(array $ast, int $depth = 1): string
{
    $lines = array_map(function ($node) use ($depth) {
        $indent = str_repeat(" ", $depth * 4 - 2);

        switch ($node['type']) {
            case 'nested':
                $formattedChildren = format($node['children'], $depth + 1);
                return "{$indent}  {$node['key']}: {$formattedChildren}";
            case 'added':
                $val = stringify($node['value'], $depth);
                return "{$indent}+ {$node['key']}: {$val}";
            case 'deleted':
                $val = stringify($node['value'], $depth);
                return "{$indent}- {$node['key']}: {$val}";
            case 'changed':
                $val1 = stringify($node['oldValue'], $depth);
                $val2 = stringify($node['newValue'], $depth);
                return "{$indent}- {$node['key']}: {$val1}\n{$indent}+ {$node['key']}: {$val2}";
            case 'unchanged':
                $val = stringify($node['value'], $depth);
                return "{$indent}  {$node['key']}: {$val}";
            default:
                throw new \Exception("Unknown node type: {$node['type']}");
        }
    }, $ast);

    $result = implode("\n", $lines);
    $closingIndent = str_repeat(" ", ($depth - 1) * 4);

    return "{\n{$result}\n{$closingIndent}}";
}
