<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array
$values = array_map('str_split', $values);

function countAround($map, $x, $y){
    $count = 0;
    if(isset($map[$x-1][$y-1]) && $map[$x-1][$y-1] === '#'){$count++;}
    if(isset($map[$x-1][$y]) && $map[$x-1][$y] === '#'){$count++;}
    if(isset($map[$x-1][$y+1]) && $map[$x-1][$y+1] === '#'){$count++;}

    if(isset($map[$x][$y-1]) && $map[$x][$y-1] === '#'){$count++;}
    if(isset($map[$x][$y+1]) && $map[$x][$y+1] === '#'){$count++;}

    if(isset($map[$x+1][$y-1]) && $map[$x+1][$y-1] === '#'){$count++;}
    if(isset($map[$x+1][$y]) && $map[$x+1][$y] === '#'){$count++;}
    if(isset($map[$x+1][$y+1]) && $map[$x+1][$y+1] === '#'){$count++;}

    return $count;
}
$map = $values;

while (true){
    $newState = [];
    foreach($map as $x => $row){
        $newState[$x] = [];
        foreach ($row as $y => $spot){
            if($spot === 'L' && countAround($map, $x, $y) === 0){
                $newState[$x][$y] = '#';
            }elseif ($spot === '#' && countAround($map, $x, $y) > 3){
                $newState[$x][$y] = 'L';
            }else{
                $newState[$x][$y] = $spot;
            }
        }
    }
    if(json_encode($map) !== json_encode($newState)){
        $map = $newState;
    }else{
        break;
    }
}

$emptySeats = array_reduce($map, function($a, $v){return $a + (array_count_values($v)['#'] ?? 0);});

echo "1: $emptySeats\n";

function countAfar($map, $x, $y){
    $count = 0;
    //TL
    $dX = $x-1;
    $dY = $y-1;
    while(isset($map[$dX][$dY]) && $map[$dX][$dY] !== 'L'){
        if($map[$dX][$dY] === '#'){
            $count++;
            break;
        }
        $dX--;
        $dY--;
    }

    //T
    $dX = $x-1;
    $dY = $y;
    while(isset($map[$dX][$dY]) && $map[$dX][$dY] !== 'L'){
        if($map[$dX][$dY] === '#'){
            $count++;
            break;
        }
        $dX--;
    }

    //TR
    $dX = $x-1;
    $dY = $y+1;
    while(isset($map[$dX][$dY]) && $map[$dX][$dY] !== 'L'){
        if($map[$dX][$dY] === '#'){
            $count++;
            break;
        }
        $dX--;
        $dY++;
    }

    //L
    $dX = $x;
    $dY = $y-1;
    while(isset($map[$dX][$dY]) && $map[$dX][$dY] !== 'L'){
        if($map[$dX][$dY] === '#'){
            $count++;
            break;
        }
        $dY--;
    }

    //R
    $dX = $x;
    $dY = $y+1;
    while(isset($map[$dX][$dY]) && $map[$dX][$dY] !== 'L'){
        if($map[$dX][$dY] === '#'){
            $count++;
            break;
        }
        $dY++;
    }

    //BL
    $dX = $x+1;
    $dY = $y-1;
    while(isset($map[$dX][$dY]) && $map[$dX][$dY] !== 'L'){
        if($map[$dX][$dY] === '#'){
            $count++;
            break;
        }
        $dX++;
        $dY--;
    }

    //B
    $dX = $x+1;
    $dY = $y;
    while(isset($map[$dX][$dY]) && $map[$dX][$dY] !== 'L'){
        if($map[$dX][$dY] === '#'){
            $count++;
            break;
        }
        $dX++;
    }

    //BR
    $dX = $x+1;
    $dY = $y+1;
    while(isset($map[$dX][$dY]) && $map[$dX][$dY] !== 'L'){
        if($map[$dX][$dY] === '#'){
            $count++;
            break;
        }
        $dX++;
        $dY++;
    }

    return $count;
}

$map = $values;
while (true){
    $newState = [];
    foreach($map as $x => $row){
        $newState[$x] = [];
        foreach ($row as $y => $spot){
            if($spot === 'L' && countAfar($map, $x, $y) === 0){
                $newState[$x][$y] = '#';
            }elseif ($spot === '#' && countAfar($map, $x, $y) > 4){
                $newState[$x][$y] = 'L';
            }else{
                $newState[$x][$y] = $spot;
            }
        }
    }
    if(json_encode($map) !== json_encode($newState)){
        $map = $newState;

    }else{
        break;
    }
}

$emptySeats = array_reduce($map, function($a, $v){return $a + (array_count_values($v)['#'] ?? 0);});

echo "2: $emptySeats\n";
