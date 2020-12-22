<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES);

$deck1 = [];
$deck2 = [];

$deck = &$deck1;
$skip = true;
foreach($values as $card){
    if($skip){
        $skip = false;
        continue;
    }
    if (!$card){
        $deck = &$deck2;
        $skip = true;
        continue;
    }
    $deck[] = $card;
}

$rdeck1 = $deck1;
$rdeck2 = $deck2;

while($deck1 && $deck2){
    $card1 = array_shift($deck1);
    $card2 = array_shift($deck2);
    if($card1 > $card2){
        array_push($deck1, $card1);
        array_push($deck1, $card2);
    }else{
        array_push($deck2, $card2);
        array_push($deck2, $card1);
    }
}

$deck = $deck1 ? $deck1 : $deck2;
$player = $deck1 ? 1: 2;

$deck = array_reverse($deck);

$sum = 0;
foreach($deck as $i => $card){
    $sum+= $card * ($i+1);
}

echo "1: $sum ($player)\n";



function checkMemory(&$memory, $deck1, $deck2){
    $set = implode(',', $deck1).'-'.implode(',', $deck2);
    if(isset($memory[$set])){
        return true;
    }
    $memory[$set] = 1;
    return false;
}

function playGame($deck1, $deck2)
{
    $memory = [];
    while($deck1 && $deck2) {
        if (checkMemory($memory, $deck1, $deck2)) {
            return [1, $deck1];
        }

        $card1 = array_shift($deck1);
        $card2 = array_shift($deck2);
        if(count($deck1) >= $card1 && count($deck2) >= $card2){
            $winner = playGame(array_slice($deck1, 0, $card1), array_slice($deck2, 0, $card2))[0];
        }else{
            $winner = ($card1 > $card2)? 1: 2;
        }
        if($winner == 1){
            array_push($deck1, $card1);
            array_push($deck1, $card2);
        }else{
            array_push($deck2, $card2);
            array_push($deck2, $card1);
        }
    }
    if($deck1){
        return [1, $deck1];
    }else{
        return [2, $deck2];
    }

}

list($player, $winner) = playGame($rdeck1, $rdeck2);
$deck = array_reverse($winner);

$sum = 0;
foreach($deck as $i => $card){
    $sum+= $card * ($i+1);
}

echo "2: $sum ($player)\n";
