<?php

namespace Hexlet\Code\Formatters\Json;

function format(array $ast): string
{
    return (string) json_encode($ast, JSON_PRETTY_PRINT);
}
