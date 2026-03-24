<?php

namespace Differ\Differ;

use function Hexlet\Code\Parsers\parse;
use function Hexlet\Code\Formatters\format;

function buildAst(array $data1, array $data2): array
{
    $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    sort($keys);

    return array_map(function ($key) use ($data1, $data2) {
        if (!array_key_exists($key, $data1)) {
            return ['key' => $key, 'type' => 'added', 'value' => $data2[$key]];
        }
        if (!array_key_exists($key, $data2)) {
            return ['key' => $key, 'type' => 'deleted', 'value' => $data1[$key]];
        }

        if (is_array($data1[$key]) && is_array($data2[$key])) {
            return [
                'key' => $key,
                'type' => 'nested',
                'children' => buildAst($data1[$key], $data2[$key])
            ];
        }

        if ($data1[$key] !== $data2[$key]) {
            return [
                'key' => $key,
                'type' => 'changed',
                'oldValue' => $data1[$key],
                'newValue' => $data2[$key]
            ];
        }

        return ['key' => $key, 'type' => 'unchanged', 'value' => $data1[$key]];
    }, $keys);
}

function genDiff(string $pathToFile1, string $pathToFile2, string $formatName = 'stylish'): string
{
    $content1 = file_get_contents($pathToFile1);
    $content2 = file_get_contents($pathToFile2);

    $extension1 = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $extension2 = pathinfo($pathToFile2, PATHINFO_EXTENSION);

    $data1 = parse((string) $content1, $extension1);
    $data2 = parse((string) $content2, $extension2);

    $ast = buildAst($data1, $data2);

    return format($ast, $formatName);
}
