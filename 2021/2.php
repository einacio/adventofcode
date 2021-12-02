<?php
if ($argc == 1) {
    echo '
    Usage: 2.php datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$x = $y = 0;

foreach($values as $line){
    $line = explode(' ', $line);
    switch ($line[0]) {
        case 'forward':
            $x += $line[1];
            break;
        case 'down':
            $y += $line[1];
            break;
        case 'up':
            $y -= $line[1];
            break;
    }
}
echo "part 1: ".($y*$x).PHP_EOL;

$x = $y = $a = 0;

foreach($values as $line){
    $line = explode(' ', $line);
    switch ($line[0]) {
        case 'forward':
            $x += $line[1];
            $y += ($a * $line[1]);
            break;
        case 'down':
            $a += $line[1];
            break;
        case 'up':
            $a -= $line[1];
            break;
    }
}

echo "part 2: ".($y*$x).PHP_EOL;
