<?php

namespace Hexlet\Code\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $content, string $extension): array
{
    if ($extension === 'json') {
        return json_decode($content, true);
    }

    if ($extension === 'yml' || $extension === 'yaml') {
        return (array) Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP);
    }

    throw new \Exception("Unknown extension: {$extension}");
}
