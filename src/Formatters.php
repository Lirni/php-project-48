<?php

namespace Hexlet\Code\Formatters;

use function Hexlet\Code\Formatters\Stylish\format as formatStylish;
use function Hexlet\Code\Formatters\Plain\format as formatPlain;
use function Hexlet\Code\Formatters\Json\format as formatJson;

function format(array $ast, string $formatName): string
{
    return match ($formatName) {
        'stylish' => formatStylish($ast),
        'plain'   => formatPlain($ast),
        'json'    => formatJson($ast),
        default   => throw new \Exception("Unknown format: {$formatName}"),
    };
}
