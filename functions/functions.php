<?php

function prelude()
{
    global $argc, $argv;

    if ($argc === 1) {
        echo "
    Usage: {$argv[0]} datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
     " . PHP_EOL;
        exit;
    }
}

function debug($debugLine)
{
    global $argv;
    if (empty($argv[2])) return;
    out($debugLine);
}

function out($out)
{
    echo $out . PHP_EOL;
}

function in()
{
    global $argv;
    return file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array
}

/**
 * Get all cell around a position
 * @param $map
 * @param $x
 * @param $y
 * @return array
 */
function getAround($map, $x, $y){
    $ret = [];

    $coordinates = [
        [$x-1, $y-1],
        [$x-1, $y],
        [$x-1, $y+1],
        [$x, $y-1],
        [$x, $y+1],
        [$x+1, $y-1],
        [$x+1, $y],
        [$x+1, $y+1],
    ];

    foreach($coordinates as [$a, $b]){
        if (isset($map[$b][$a])) {
            if(!isset($ret[$b])){
                $ret[$b] = [];
            }
            $ret[$b][$a] = $map[$b][$a];
        }
    }
    return $ret;
}