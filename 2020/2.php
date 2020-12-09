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

$total1 = 0;
$total2 = 0;
foreach ($values as $line) {
    list($rules, $char, $pass) = explode(' ', $line);
    list($min, $max) = explode('-', $rules);
    $char     = $char[0];
    $charCode = ord($char);
    $counts   = count_chars($pass, 1);
    //echo(json_encode($counts));
    if (isset($counts[$charCode])) {
        if ($counts[$charCode] >= $min && $counts[$charCode] <= $max) {
            $total1 ++;
        }
    }
    if (strlen($pass) >= $max && ($pass[$min - 1] === $char xor $pass[$max - 1] === $char)) {
        $total2 ++;
    }
}

echo "1: $total1\n";
echo "2: $total2\n";

