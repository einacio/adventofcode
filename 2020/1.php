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
$values = array_flip($values); // convert values into indices, that give us easier/faster access and dedup

// polyfill pre 7.3
if (!function_exists('array_key_first')) {
    function array_key_first(array $arr)
    {
        foreach ($arr as $key => $unused) {
            return $key;
        }

        return null;
    }
}


foreach ($values as $n => $i) {
    // check if the complement exists
    $counterPart = 2020 - $n;
    if (isset($values[$counterPart])) {
        echo $n * $counterPart . "\n";
        break;
    }
}

while (count($values) > 3) {
    // take out the first value in the list
    $currentPivot = array_key_first($values);
    unset($values[$currentPivot]);

    //same logic but with the extra first value
    foreach ($values as $n => $i) {
        // find complement to the 2 values we know
        $counterPart = 2020 - ($n + $currentPivot);
        if (isset($values[$counterPart])) {
            echo $n * $counterPart * $currentPivot;
            exit;
        }
    }
}
