<?php
if ($argc == 1) {
    echo '
    Usage: '.__FILE__.' datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$fishes = array_count_values(explode(',', $values[0])) + array_fill(0,9, 0);

$day = 80;
while($day--){

    $fishes=[
        $fishes[1],
        $fishes[2],
        $fishes[3],
        $fishes[4],
        $fishes[5],
        $fishes[6],
        $fishes[7] + $fishes[0],
        $fishes[8],
        $fishes[0]
    ];

}

echo 'Part 1: '.array_sum($fishes).PHP_EOL;

$fishes = array_count_values(explode(',', $values[0])) + array_fill(0,9, 0);

$day = (10**10**100);
while($day--){
    $fishes=[
        $fishes[1],
        $fishes[2],
        $fishes[3],
        $fishes[4],
        $fishes[5],
        $fishes[6],
        $fishes[7] + $fishes[0],
        $fishes[8],
        $fishes[0]
    ];
}

echo 'Part 2: '.array_sum($fishes).PHP_EOL;
