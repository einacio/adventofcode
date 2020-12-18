<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

function solve($formula){
    preg_match_all('/(\d+|\+|\*)/', $formula, $parts);
    $acc = 0;
    $op = '+';
    foreach($parts[1] as $part){
        if(is_numeric($part)){
            if($op === '+'){
                $acc += $part;
            }else{
                $acc *= $part;
            }
        }else{
            $op = $part;
        }
    }
    return $acc;
}
$sum = 0;
foreach($values as $problem){
    while(preg_match('/\(([\d+* ]+)\)/', $problem, $matches)){
        $val = solve($matches[1]);
        $problem = str_replace($matches[0], $val, $problem);
    }
    $sum += solve($problem);
}

echo "1: $sum\n";


function advancedSolve($formula){
    while(preg_match('/\d+ \+ \d+/', $formula, $matches)){
        $val = solve($matches[0]);
        //we can't use str_replace because it could happen: "2 + 4 + 22 + 48" => "6 + 268"
        //so re replace only one per iteration
        $formula = substr_replace($formula, $val, strpos($formula, $matches[0]), strlen($matches[0]));
    }
    while(preg_match('/\d+ \* \d+/', $formula, $matches)){
        $val = solve($matches[0]);
        $formula = substr_replace($formula, $val, strpos($formula, $matches[0]), strlen($matches[0]));
    }
    return $formula;
}

$sum = 0;
foreach($values as $problem){
    echo $problem."\n";
    while(preg_match('/\(([\d+* ]+)\)/', $problem, $matches)){
        $val = advancedSolve($matches[1]);
        $problem = str_replace($matches[0], $val, $problem);
    }
    echo $problem."\n";
    $tmp = advancedSolve($problem);
    echo $tmp."\n";
    $sum += $tmp;
}

echo "2: $sum\n";
