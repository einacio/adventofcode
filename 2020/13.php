<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$limit = $values[0];
$times = array_filter(explode(',', $values[1]), function ($v){return $v !== 'x';});

$min = PHP_INT_MAX;
$res = 0;
foreach($times as $id){
    $time = ceil($limit / $id) * $id;
    if ($time < $min){
        $min = $time;
        $res = $id * ($time - $limit);
    }
}

echo "1: $res\n";

$test = $argv[2];

$subTimes = array_slice($times, 1, null, 1);

$time = 0;
$acc = $times[0];
//based on https://pastebin.com/jHpRYhzc
//we find the next coincident time. from then on, we multiply for the new frequency, since that's the combined interval
//it's basically bruteforce, but we know which values to skip
foreach($subTimes as $diff=>$id){
    while(($time+$diff) % $id !== 0) {
        $time += $acc;
    }
    $acc *= $id;
}

echo "2: $time\n";
