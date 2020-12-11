<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$windowSize = $argv[2]??25;


$currentWindow = array_slice($values, 0, $windowSize);
$i = $windowSize;
while(true){
    $newVal = $values[$i];
    $testWindow = $currentWindow;

    $valid = false;
    while($testWindow){
        $test = array_shift($testWindow);
        if(in_array($newVal - $test, $testWindow)){
            $valid = true;
            break;
        }
    }

    if(!$valid){
        break;
    }

    array_shift($currentWindow);
    $currentWindow[] = $newVal;
    $i++;
}

echo "1: $newVal\n";

// this could be done just tracking min, max and windowSum, which should be much faster,
// but meh, it's less than half second as it is
$i = 0;
while(true){
    $j = $i+1;
    $window = [$values[$i], $values[$j]];
    while(true){
        $sum = array_sum($window);
        if($sum > $newVal){
            break;
        }
        if($sum == $newVal){
            break 2;
        }
        $j++;
        $window[] = $values[$j];
    }
    $i++;
}

echo "2: ".(min($window) + max($window))."\n";
