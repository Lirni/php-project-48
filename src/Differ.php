<?php

namespace Hexlet\Code\Differ;

use function Hexlet\Code\Parsers\parse;

function toString(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    return (string) $value;
}

function genDiff(string $pathToFile1, string $pathToFile2): string
{

    $content1 = file_get_contents($pathToFile1);
    $content2 = file_get_contents($pathToFile2);

    $extension1 = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $extension2 = pathinfo($pathToFile2, PATHINFO_EXTENSION);

    $data1 = parse((string) $content1, $extension1);
    $data2 = parse((string) $content2, $extension2);

    $allKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    $sortedKeys = $allKeys;
    sort($sortedKeys);

    $lines = array_map(function ($key) use ($data1, $data2) {
        $exists1 = array_key_exists($key, $data1);
        $exists2 = array_key_exists($key, $data2);

        if ($exists1 && $exists2 && $data1[$key] === $data2[$key]) {
            return "    {$key}: " . toString($data1[$key]);
        }

        if ($exists1 && $exists2 && $data1[$key] !== $data2[$key]) {
            $line1 = "  - {$key}: " . toString($data1[$key]);
            $line2 = "  + {$key}: " . toString($data2[$key]);
            return "{$line1}\n{$line2}";
        }

        if ($exists1 && !$exists2) {
            return "  - {$key}: " . toString($data1[$key]);
        }

        return "  + {$key}: " . toString($data2[$key]);
    }, $sortedKeys);

    return "{\n" . implode("\n", $lines) . "\n}";
}
