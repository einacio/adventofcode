<?php
require_once __DIR__ . '/../functions/functions.php';

prelude();

$values = in();

//parts 1 and 2

$processedMap = [];
$groups = [];
$curGroup = -1;
$inGroup = false;

foreach ($values as $y => $row) {
    $processedMap[$y] = [];
    $row = str_split($row);
    foreach ($row as $x => $value) {
        if (ctype_digit($value)) {
            if (!$inGroup) {
                $inGroup = true;
                $curGroup++;
                $groups[$curGroup] = '';
            }
            $groups[$curGroup] .= $value;
            $value = $curGroup;
        } else {
            $inGroup = false;
        }
        $processedMap[$y][$x] = $value;
    }
}

$foundParts = [];
$foundGears = [];

foreach ($processedMap as $y => $row) {
    foreach ($row as $x => $value) {
        if(!is_numeric($value) && $value !== '.') {
            //flatten and filter only group numbers
            $partsAround = array_values(array_unique(array_reduce(
                getAround($processedMap, $x, $y),
                function ($c, $v) {
                    $a = array_values(array_filter($v, 'is_numeric'));
                    return array_merge($c, $a);
                },
                [])));
            //for part1
            $foundParts = array_merge($foundParts, $partsAround);

            //for part2
            if($value === '*' && count($partsAround) === 2){
                $foundGears[] = $partsAround;
            }
        }
    }
}
$foundParts = array_unique($foundParts);

$total = 0;
foreach($foundParts as $part){
    $total += $groups[$part];
}

out("1: {$total}");

$total = 0;
foreach($foundGears as $gearParts){
    $total += $groups[$gearParts[0]] * $groups[$gearParts[1]];
}

out("2: {$total}");