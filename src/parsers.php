<?php

namespace GenDiff\Parse;

use Symfony\Component\Yaml\Yaml;

function parse($data, $type)
{
    switch ($type) {
        case 'json':
            return json_decode($data, true);
        case 'yaml':
            return Yaml::parse($data);
        case 'yml':
            return Yaml::parse($data);
        default:
            return 'Unknow parser!';
    }
}
