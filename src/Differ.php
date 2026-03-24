<?php

namespace Hexlet\Code\Differ;

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
    $data1 = json_decode((string) file_get_contents($pathToFile1), true);
    $data2 = json_decode((string) file_get_contents($pathToFile2), true);

    $allKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    
    $sortedKeys = $allKeys;
    sort($sortedKeys);

    $lines = array_map(function ($key) use ($data1, $data2) {
        $existsIn1 = array_key_exists($key, $data1);
        $existsIn2 = array_key_exists($key, $data2);

        if ($existsIn1 && $existsIn2 && $data1[$key] === $data2[$key]) {
            return "    {$key}: " . toString($data1[$key]);
        }
        
        if ($existsIn1 && $existsIn2 && $data1[$key] !== $data2[$key]) {
            $line1 = "  - {$key}: " . toString($data1[$key]);
            $line2 = "  + {$key}: " . toString($data2[$key]);
            return "{$line1}\n{$line2}";
        }

        if ($existsIn1 && !$existsIn2) {
            return "  - {$key}: " . toString($data1[$key]);
        }

        return "  + {$key}: " . toString($data2[$key]);
        
    }, $sortedKeys);

    $result = "{\n" . implode("\n", $lines) . "\n}";

    return $result;
}
