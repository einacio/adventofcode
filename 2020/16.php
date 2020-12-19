<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES); // load file into array

$ranges = [];
$i = 0;
while($line = $values[$i++]){
    list($range1, $range2) = explode(' or ', explode(': ', $line)[1]);
    $ranges[] = explode('-', $range1);
    $ranges[] = explode('-', $range2);
}

$i++;
$mine = explode(',', $values[$i++]);

$tickets = [];
while(isset($values[++$i]) && $line = $values[$i]){
$tickets[] = explode(',', $line);
}

$sum = 0;
foreach($tickets as $ticket){
    foreach ($ticket as $value){
        $valid = false;
        foreach ($ranges as $range){
            if($value >= $range[0] && $value <= $range[1]){
                $valid = true;
                break;
            }
        }
        if(!$valid){
            $sum += $value;
        }
    }
}

echo "1: $sum\n";
