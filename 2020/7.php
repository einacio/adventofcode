<?php
if ($argc == 1) {
    echo '
    Usage: 7.php datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

function findContainerBags($list, $color)
{
    $containerRows = array_filter(
        $list, function ($v) use ($color) {
        return strpos($v, $color, 1);
    });
    $colors        = array_map(
        function ($v) {
            return explode(' bags', $v)[0];
        }, $containerRows);

    return $colors;
}

$colorsToFind = ['shiny gold'];
$found        = [];

while ($colorsToFind) {
    $color        = array_pop($colorsToFind);
    $colorsToFind += findContainerBags($values, $color);
    foreach ($colorsToFind as $find) {
        $found[$find] = 1;
    }
}
$count = count($found);
echo "1: $count\n";


function findContainedBags($list, $color)
{
    $containerRows = array_filter(
        $list, function ($v) use ($color) {
        return strpos($v, $color, 0) === 0;
    });
    $colors        = array_map(
        function ($v) {
            preg_match_all(
                '/(\d+) (\w+ \w+) bag/',
                explode('contain', $v)[1], $matches, PREG_SET_ORDER);
            foreach ($matches as &$match) {
                unset($match[0]);
            }

            return $matches;
        }, $containerRows);

    return reset($colors);
}

$count = 0;

$childs  = [];
$toCheck = ['shiny gold'];
while ($toCheck) {
    $color = array_pop($toCheck);
    if (!isset($childs[$color])) {
        $bags = findContainedBags($values, $color);
        foreach ($bags as $bag) {
            $toCheck[] = $bag[2];
        }
        $childs[$color] = $bags;
    }
}

// sloppy way, i don't care for a better recursive solution now.
// first re replace every color with the bags it contains
// then we replace every array with a number
$pending = true;
while ($pending) {
    $pending = false;
    foreach ($childs as &$bags) {
        if (is_array($bags)) {
            $pending = true;
            //empty array, empty bag
            if (!$bags) {
                $bags = 0;
                continue;
            }
            $fullyReplaced = true;
            foreach ($bags as &$bag) {
                if (!is_numeric($bag[2])) {
                    $fullyReplaced = false;
                    if (is_int($childs[$bag[2]])) {
                        $bag[2] = $childs[$bag[2]];
                    }
                }
            }
            if ($fullyReplaced) {
                $bags = array_reduce(
                    $bags, function ($a, $v) {
                    return $a + $v[1] + $v[1] * $v[2];
                }, 0);
            }
        }
    }
}

echo "2: {$childs['shiny gold']}\n";


