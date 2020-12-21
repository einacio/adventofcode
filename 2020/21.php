<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$ingredients = [];
$allergens = [];

foreach ($values as $line){
    [$ing, $adv] = explode(' (contains ', $line);
    $ing = explode(' ', $ing);
    $adv = explode(', ', substr($adv, 0, -1));
    foreach ($ing as $i){
        if(!isset($ingredients[$i])){
            $ingredients[$i] = ['count'=>1, 'all'=>[], 'canbe'=>[]];
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
foreach ($ingredients as $name => &$ing){
    foreach ($ing['all'] as $al => $count){
        if($allergens[$al] == $count){
            $ing['canbe'][] = $al;
        }
    }
    if(!$ing['canbe']){
        $clean[$name] = $ing['count'];
        unset($ingredients[$name]);
    }
}

echo '1: '.array_sum($clean)."\n";

$is = [];
while($allergens) {
    foreach ($ingredients as $name => &$ing) {
        if(!$ing['canbe']) continue;
        foreach($ing['canbe'] as $i=>$prob){
            if(!isset($allergens[$prob])){
                unset($ing['canbe'][$i]);
            }
        }
        if(count($ing['canbe']) == 1){
            $al = reset($ing['canbe']);
            $is[$al] = $name;
            unset($allergens[$al]);
        }
    }
}

ksort($is);
echo '2: '.implode(',', $is)."\n";
