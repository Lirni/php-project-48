<?php

namespace Hexlet\Code\Differ;

function genDiff($pathToFile1, $pathToFile2)
{
    $content1 = file_get_contents($pathToFile1);
    $content2 = file_get_contents($pathToFile2);

    $data1 = json_decode($content1);
    $data2 = json_decode($content2);

    print_r($data1);
    print_r($data2);
}