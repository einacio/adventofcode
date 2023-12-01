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