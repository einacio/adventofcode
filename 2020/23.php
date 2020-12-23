<?php

$values = str_split($argv[1]);


function rotateTo($array, $pivot){
    $pos = array_search($pivot, $array);
    $result = array_slice($array, $pos);
    $result = array_merge($result, array_slice($array, 0, $pos));
    return $result;
}

function moveCups(&$array){

    $current = $array[0];
    $extract = array_splice($array, 1, 3);

    $destination = $current;
    $found = false;
    while(!$found){
        $destination--;
        if(!$destination){
            $destination = max($array);
        }
        $found = array_search($destination, $array);
    }
    array_splice($array, $found+1, 0, $extract);

    array_shift($array);
    array_push($array, $current);
}

$count = 100;
while ($count--){
    moveCups($values);
}
$values = rotateTo($values, 1);
array_shift($values);
echo '1: '.implode($values)."\n";
