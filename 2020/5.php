<?php
if ($argc == 1) {
    echo '
    Usage: 5.php datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$ids = array_map(function($v){return intval(strtr($v, ['R'=>'1','B'=>'1','F'=>'0','L'=>'0']),2);}, $values);
sort($ids);
//$max = max($ids);
$max = $ids[count($ids)-1];
echo "1: $max\n";

$prev = $ids[0];
foreach ($ids as $id){
    if ($id === $prev+2){
        echo "2: ".($id-1)."\n";
        exit;
    }
    $prev = $id;
}
