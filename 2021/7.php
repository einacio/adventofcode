<?php
if ($argc == 1) {
    echo '
    Usage: '.__FILE__.' datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$values = explode(',', $values[0]);

sort($values);

$middle = (count($values)+1)/2 -1;
$median = ($values[floor($middle)] + $values[ceil($middle)])/2;

$fuel = 0;
foreach ($values as $value){
    $fuel += abs($value - $median);
}

echo 'Part 1: '.$fuel.PHP_EOL;

function calc($diff){
    static $vals = [0=>0, 1=>1];
    if(!isset($vals[$diff])){
        $vals[$diff] = calc($diff-1)+$diff;
    }
    return $vals[$diff];
}

$avg = array_sum($values)/count($values);

$min_fuel = PHP_INT_MAX;
$up = 0;
foreach(range(floor($avg), ceil($avg)) as $point){
    $fuel = 0;
    foreach($values as $value){
        $fuel += calc(abs($value - $point));
        if($fuel > $min_fuel){
            continue 2;
        }
    }
    $min_fuel = $fuel;
    $up = $point;
}
echo 'Part 2: '.$min_fuel.PHP_EOL;