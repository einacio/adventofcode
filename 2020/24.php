<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array


function calculateCoordinate($instructions){
    $x = 0;
    $y = 0;

    //add a space for the last e/w check
    $instructions = str_split($instructions.' ');
    $pos = 0;
    while($pos < count($instructions)-1){
        $instruction = $instructions[$pos];
        $pos++;
        if($instruction == 'e') {
            $x += 2;
        }elseif($instruction == 'w'){
            $x -= 2;
        }else {
            if ($instruction == 'n') {
                $y += 1;
            } else {
                $y -= 1;
            }
            $instruction = $instructions[$pos];
            $pos++;

            if($instruction === 'e'){
                $x += 1;
            }elseif ($instruction === 'w'){
                $x -= 1;
            }
        }

    }
    return [$x, $y];
}

$tiles = [];
foreach($values as $instruction){
    [$x, $y] = calculateCoordinate($instruction);
    if(!isset($tiles[$x])){
        $tiles[$x] = [];
    }
    if(!isset($tiles[$x][$y])){
        $tiles[$x][$y] = 1;
    }else{
        $tiles[$x][$y] = !$tiles[$x][$y];
    }
}
$sum = 0;
foreach ($tiles as $row){
    $sum += array_sum($row);
}

echo "1: $sum\n";


function fillAround(&$map, $x, $y){
    if(!isset($map[$x+1])){
        $map[$x+1] = [];
    }
    if(!isset($map[$x+2])){
        $map[$x+2] = [];
    }
    if(!isset($map[$x-1])){
        $map[$x-1] = [];
    }
    if(!isset($map[$x-2])){
        $map[$x-2] = [];
    }

    if(!isset($map[$x+1][$y+1])){
        $map[$x+1][$y+1] = 0;
    }
    if(!isset($map[$x-1][$y+1])){
        $map[$x-1][$y+1] = 0;
    }

    if(!isset($map[$x+1][$y-1])){
        $map[$x+1][$y-1] = 0;
    }
    if(!isset($map[$x-1][$y-1])){
        $map[$x-1][$y-1] = 0;
    }

    if(!isset($map[$x+2][$y])){
        $map[$x+2][$y] = 0;
    }
    if(!isset($map[$x-2][$y])){
        $map[$x-2][$y] = 0;
    }

    // fill place for marks map
    if(!isset($map[$x][$y])){
        $map[$x][$y] = 0;
    }
}

function markAround(&$map, $x, $y){
    fillAround($map, $x, $y);
    $map[$x+1][$y+1]++;
    $map[$x-1][$y+1]++;
    $map[$x+1][$y-1]++;
    $map[$x-1][$y-1]++;
    $map[$x+2][$y]++;
    $map[$x-2][$y]++;
}


$count = 100;
while($count--) {
    $marks = [];
    foreach ($tiles as $x => $row) {
        foreach($row as $y => $val){
            fillAround($tiles, $x, $y);
            if($val){
                markAround($marks, $x, $y);
            }
        }
    }

    foreach($marks as $x => $row){
        foreach($row as $y => $val){
            if(!$val || $val > 2){
                if($tiles[$x][$y]){
                    $tiles[$x][$y] = 0;
                }
            }elseif($val == 2){
                if(!$tiles[$x][$y]){
                    $tiles[$x][$y] = 1;
                }
            }
        }
    }
}

$sum = 0;
foreach ($tiles as $row){
    $sum += array_sum($row);
}

echo "2: $sum\n";
