<?php
declare(strict_types = 1);


if ($argc == 1) {
    echo '
    Usage: 6.php datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file(
    $argv[1],
    FILE_IGNORE_NEW_LINES); // load file into array. no FILE_SKIP_EMPTY_LINES since those are record separators

$groupSize = 0;
$groupCount = [];
$total = 0;
$total2 = 0;
foreach($values as $value){
    if(!$value){
        $total += count($groupCount);
        $total2 += array_reduce($groupCount,
            function($acc, $v)use($groupSize){
            if($v == $groupSize){
                $acc++;
            }
            return $acc;
        },0);
        $groupSize = 0;
        $groupCount = [];
        continue;
    }
    $groupSize++;
    foreach(str_split($value) as $letter){
        $groupCount[$letter] = isset($groupCount[$letter])?$groupCount[$letter]+1:1;
    }
}
//last group
$total += count($groupCount);
$total2 += array_reduce($groupCount,
            function($acc, $v)use($groupSize){
            if($v == $groupSize){
                $acc++;
            }
            return $acc;
        },0);

echo "1: $total\n";
echo "2: $total2\n";
