<?php

require_once __DIR__ . '/../functions/functions.php';

prelude();

$values = in();

//part 1 & 2

$total1 = 0;

$copies = [];
$currentCard = 0;
$maxCard = count($values);

foreach ($values as $row){
    $currentCard++;
    [$_, $numbers] = explode(': ', $row);
    [$winning, $have] = explode(' | ', $numbers);
    $winning = explode(',', preg_replace('/\s+/', ',', trim($winning)));
    $have = explode(',', preg_replace('/\s+/', ',', trim($have)));

    $matches = array_intersect($winning, $have);
    sort($matches);
    debug(json_encode($matches));
    $mc = count($matches);
    if($mc) {
        $total1 += pow(2, $mc-1);
    }
    $copies[$currentCard] = ($copies[$currentCard]??0) + 1;

    while($mc){
        if($currentCard+$mc <= $maxCard){
            $copies[$currentCard+$mc] = ($copies[$currentCard+$mc]??0) + $copies[$currentCard];
        }
        $mc--;
    }
}
$total2 = array_sum($copies);

out("1: {$total1}");
out("2: {$total2}");