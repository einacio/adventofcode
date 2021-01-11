<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$res = '';
$curLetter = '';

while($curLetter != ';') {
    $res.=$curLetter;
    preg_match_all("/{$curLetter}(.)/", $values[0], $matches);
    $frequencies = array_count_values($matches[1]);
    arsort($frequencies);
    $curLetter = array_key_first($frequencies);
}

echo $res."\n";
