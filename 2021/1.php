<?php
if ($argc == 1) {
    echo '
    Usage: 1.php datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

//part 1

$val = $values[0];

$count = array_reduce($values, function ($carry, $val){
    return [$val, ($val>$carry[0])?$carry[1]+1:$carry[1]];
}, [$val, 0]);
echo "Part 1: {$count[1]}".PHP_EOL;

$count = array_reduce($values, function ($carry, $val){
    $cur = array_sum($carry[0]);
    $new = [$carry[0][1], $carry[0][2], $val];
    $new_sum = array_sum($new);

    return [$new, ($new_sum>$cur)?$carry[1]+1:$carry[1]];
}, [[$values[0], $values[1], $values[2]], 0]);
echo "Part 2: {$count[1]}".PHP_EOL;
