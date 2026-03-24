<?php

namespace Hexlet\Code\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $content, string $extension): array
{
    if ($content === '') {
        return [];
    }

    $data = null;
    if ($extension === 'json') {
        $data = json_decode($content, true);
    } elseif ($extension === 'yml' || $extension === 'yaml') {
        $data = Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP);
    } else {
        throw new \Exception("Unknown extension: {$extension}");
    }
    return json_decode((string) json_encode($data), true);
}
