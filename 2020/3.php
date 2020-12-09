<?php
if ($argc == 1) {
    echo '
    Usage: 3.php datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

function ride($map, $slope)
{
    $l = strlen($map[0]);
    $trees = 0;
    $i = 0;
    foreach ($map as $row) {
        $i += $slope;
        if ($i >= $l) {
            $i -= $l;
        }
        if ($row[$i] === '#') {
            $trees ++;
        }
    }
    return $trees;
}
// first line is never used, remove it
$subValues = array_slice($values, 1);
$trees = ride($subValues, 3);
echo "1: $trees\n";

$trees *= ride($subValues, 1);
$trees *= ride($subValues, 5);
$trees *= ride($subValues, 7);

// this one is slope (1,2) so we only need to check the even rows of the (modified) map
$steppedValues = array_values(array_filter($subValues, function($key){return $key%2 == 1;}, ARRAY_FILTER_USE_KEY));
$trees *= ride($steppedValues, 1);

echo "2: $trees\n";
