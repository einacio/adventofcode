<?php
require_once __DIR__ . '/../functions/functions.php';

prelude();

$values = in();

//part 1 & 2

$total = 0;
$totalPower = 0;

foreach($values as $line){
    $foundCubes = ['red'=>0, 'blue'=>0, 'green'=>0];
    [$gameN, $gameC] = explode(': ', $line);
    foreach (explode('; ', $gameC) as $game){
        foreach(explode(', ', $game) as $cubes){
            [$cubeN, $cubeColor] = explode(' ', $cubes);
            if($cubeN > $foundCubes[$cubeColor]){
                $foundCubes[$cubeColor] = $cubeN;
            }
        }
    }
    if($foundCubes['red'] <= 12 && $foundCubes['green'] <= 13 && $foundCubes['blue'] <= 14){
        $total += explode(' ', $gameN)[1];
    }
    $power = $foundCubes['red'] * $foundCubes['green'] * $foundCubes['blue'];
    debug($power);
    $totalPower += $power;
}

out('1: '.$total);
out('2: '.$totalPower);