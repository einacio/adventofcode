<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$ingredients = [];
$allergens = [];

foreach ($values as $line){
    list($ing, $adv) = explode(' (contains ', $line);
    $ing = explode(' ', $ing);
    $adv = explode(', ', substr($adv, 0, -1));
    foreach ($ing as $i){
        if(!isset($ingredients[$i])){
            $ingredients[$i] = ['count'=>1, 'all'=>[]];
        }else{
            $ingredients[$i]['count']++;
        }
    }
    foreach ($adv as $a){
        if(!isset($allergens[$a])){
            $allergens[$a] = 1;
        }else{
            $allergens[$a]++;
        }
        foreach ($ing as $i){
            if(!isset($ingredients[$i]['all'][$a])){
                $ingredients[$i]['all'][$a] = 1;
            }else{
                $ingredients[$i]['all'][$a]++;
            }
        }
    }
}


$clean = [];
foreach ($ingredients as $name => $ing){
    foreach ($ing['all'] as $al => $count){
        if($allergens[$al] <= $count){
            continue 2;
        }
    }
    $clean[$name] = $ing['count'];
}

echo '1: '.array_sum($clean)."\n";
