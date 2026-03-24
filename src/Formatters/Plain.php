<?php

namespace Hexlet\Code\Formatters\Plain;

function stringify(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    if (is_array($value) || is_object($value)) {
        return '[complex value]';
    }
    if (is_string($value)) {
        return "'{$value}'";
    }
    return (string) $value;
}

function format(array $ast, string $parentPath = ''): string
{
    $lines = array_map(function ($node) use ($parentPath) {
        $property = $parentPath === '' ? $node['key'] : "{$parentPath}.{$node['key']}";

        switch ($node['type']) {
            case 'nested':
                return format($node['children'], $property);
            case 'added':
                $val = stringify($node['value']);
                return "Property '{$property}' was added with value: {$val}";
            case 'deleted':
                return "Property '{$property}' was removed";
            case 'changed':
                $valOld = stringify($node['oldValue']);
                $valNew = stringify($node['newValue']);
                return "Property '{$property}' was updated. From {$valOld} to {$valNew}";
            case 'unchanged':
                return null;
            default:
                throw new \Exception("Unknown node type: {$node['type']}");
        }
    }, $ast);
    return implode("\n", array_filter($lines));
}
