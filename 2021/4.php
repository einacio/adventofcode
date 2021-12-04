<?php
if ($argc == 1) {
    echo '
    Usage: 4.php datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$numbers = explode(',',array_shift($values));

$boards = [];

$board = array_fill(0,10, []);
$i = 0;
while($line = array_shift($values)){
    $line = array_values(array_filter(explode(' ', $line), 'is_numeric'));
    $board[$i] = $line;
    foreach($line as $j => $n){
        $board[5+$j][] = $n;
    }
    $i++;
    if ($i == 5){
        $boards[] = $board;
        $board = array_fill(0,10, []);
        $i = 0;
    }
}

$game1 = $boards;
$numbers1 = $numbers;

$bingo = false;
$bingo2 = false;
while ($numbers1){
    $number = array_shift($numbers1);
    foreach($boards as $bn => &$board){
        foreach ($board as &$line){
            $p = array_search($number, $line);
            if($p!== false){
                unset($line[$p]);
            }
            if ($bingo===false && !$line){
                $bingo = $bn;
                $game1 = $boards;
                $number1 = $number;
            }
            if (!$line){
                $bingo2 = $bn;
                $game2 = $boards;
                $number2 = $number;
                unset($boards[$bn]);
            }

        }
    }
}

$sum = array_reduce(array_slice($game1[$bingo], 0,5), function($c, $v){return $c + array_sum($v);}, 0);

echo 'Part 1: '.($sum*$number1).PHP_EOL;

$sum2 = array_reduce(array_slice($game2[$bingo2], 0,5), function($c, $v){return $c + array_sum($v);}, 0);

echo 'Part 2: '.($sum2*$number2).PHP_EOL;
