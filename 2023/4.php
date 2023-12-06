<?php

require_once __DIR__ . '/../functions/functions.php';

prelude();

$values = in();

//part 1

$total = 0;

foreach ($values as $row){
    [$_, $numbers] = explode(': ', $row);
    [$winning, $have] = explode(' | ', $numbers);
    $winning = explode(',', preg_replace('/\s+/', ',', trim($winning)));
    $have = explode(',', preg_replace('/\s+/', ',', trim($have)));

    $matches = array_intersect($winning, $have);
    sort($matches);
    debug(json_encode($matches));
    $mc = count($matches);
    if($mc) {
        $total += pow(2, $mc-1);
    }
}

out("1: {$total}");