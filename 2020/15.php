<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array
$countTo = $argv[2] -1;

$numbers = array_flip(explode(',', $values[0]));
$currentCount = count($numbers);
$numberToCheck = 0;

while ($currentCount < $countTo){
    if(isset($numbers[$numberToCheck])){
        $newNumber = $currentCount - $numbers[$numberToCheck];
    }else{
        $newNumber = 0;
    }
    $numbers[$numberToCheck] = $currentCount;
    $numberToCheck = $newNumber;
    $currentCount++;
}

echo "res: $numberToCheck";
