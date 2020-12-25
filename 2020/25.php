<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array


function transform($v, $n){
    $v *= $n;
    return $v % 20201227;
}

$v = 1;
$n = 7;
$i = 0;
while ($v != $values[0]){
    $i++;
    $v = transform($v, $n);
}

$n = $values[1];
$v = 1;
while ($i--){
    $v = transform($v, $n);
}

echo "1: $v\n";
