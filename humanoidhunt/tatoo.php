<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$res = '';
foreach ($values as $line){
    $bytes = str_split($line, 8);
    $bytes = array_map('bindec', $bytes);
    $ln = count($bytes);
    $i = 0;
    while($i < $ln){
        if($bytes[$i] < $ln){
            break;
        }
        $i++;
    }
    while(true){
        if($bytes[$i] >= $ln){
            $res .= chr($bytes[$i]);
            break;
        }
        $i = $bytes[$i];
    }
}
echo $res."\n";
