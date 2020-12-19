<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES); // load file into array

$ranges = [];
$i = 0;
while($line = $values[$i++]){
    [$name, $blocks] = explode(': ', $line);
    [$range1, $range2] = explode(' or ', $blocks);
    $ranges[$name] = [explode('-', $range1), explode('-', $range2)];
}

$i++;
$mine = explode(',', $values[$i++]);

$i++;
$i++;
$tickets = [];
while(isset($values[$i]) && $line = $values[$i]){
    $i++;
    $tickets[] = explode(',', $line);
}

$sum = 0;
foreach($tickets as $i => $ticket){
    foreach ($ticket as $value){
        $valid = false;
        foreach ($ranges as $rangeBlock){
            foreach($rangeBlock as $range){
                if ($value >= $range[0] && $value <= $range[1]) {
                    $valid = true;
                    break;
                }
            }
        }
        if(!$valid){
            $sum += $value;
            unset($tickets[$i]);
        }
    }
}

echo "1: $sum\n";

$found = [];
$len = count($mine) -1;

$tickets[] = $mine;

while($ranges){
    foreach ($ranges as $name => $rangeBlock){
        $target = null;
        foreach(range(0, $len) as $i) {
            if(isset($found[$i])){
                continue;
            }
            //check if it's valid for all tickets on that field
            $invalid = false;
            foreach ($tickets as $ticket){
                if (
                    !(
                        ($ticket[$i] >= $rangeBlock[0][0] && $ticket[$i] <= $rangeBlock[0][1]) ||
                        ($ticket[$i] >= $rangeBlock[1][0] && $ticket[$i] <= $rangeBlock[1][1])
                    )
                    ) {
                    $invalid = true;
                    break;
                }
            }
            if(!$invalid){
                //if it's valid for mor than one field, skip it until next iteration
                if(!is_null($target)){
                    $target = null;
                    break;
                }else{
                    $target = $i;
                }
            }
        }
        //at this point, it's valid only for one field, mark it
        if(!is_null($target)){
            $found[$target] = $name;
            unset($ranges[$name]);
        }
    }
}

$total = 1;
foreach(array_filter($found, function($v){return strpos($v,'departure')===0;}) as $field=>$n){
    $total *= $mine[$field];
}

echo "2: $total\n";
