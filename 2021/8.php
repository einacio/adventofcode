<?php
if ($argc == 1) {
    echo '
    Usage: ' . __FILE__ . ' datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$values = array_reduce($values, function ($c, $v) {
    $v = explode(' | ', $v);
    $c[] = [explode(' ', $v[0]),
        explode(' ', $v[1])];
    return $c;
}, []);
$part1 = array_reduce($values, function ($c, $v) {
    $v = $v[1];
    array_walk($v, function (&$v) {
        $v = strlen($v);
    });
    $v = array_filter($v, function ($v) {
        return $v < 5 || $v == 7;
    });
    $c[] = $v;
    return $c;
}, []);
$sum = array_reduce($part1, function ($c, $v) {
    return $c + count($v);
}, 0);

echo 'Part 1: ' . $sum . PHP_EOL;

function resort($s){
    $a = str_split($s);
    sort($a);
    return implode('', $a);
}

function identify($numbers)
{
    $decoded = [];
    $l5 = [];
    $l6 = [];
    foreach ($numbers as $number) {
        $number = resort($number);
        switch (strlen($number)) {
            case 2:
                $decoded[1] = $number;
                break;
            case 3:
                $decoded[7] = $number;
                break;
            case 4:
                $decoded[4] = $number;
                break;
            case 7:
                $decoded[8] = $number;
                break;
            case 5:
                $l5[] = $number;
                break;
            case 6:
                $l6[] = $number;
                break;
        }
    }
    foreach($l6 as $l){
        $diff = array_diff(str_split($decoded[1]), str_split($l));
        if($diff){
            $decoded[6] = $l;
            continue;
        }
        $diff = array_diff(str_split($decoded[4]), str_split($l));
        if($diff){
            $decoded[0] = $l;
            continue;
        }
        $decoded[9] = $l;
    }
    foreach($l5 as $l){
        $diff = array_diff(str_split($decoded[1]), str_split($l));
        if(!$diff){
            $decoded[3] = $l;
            continue;
        }
        $diff = array_diff(str_split($decoded[4]), str_split($l));
        if(count($diff) === 1){
            $decoded[5] = $l;
            continue;
        }
        $decoded[2] = $l;
    }

    return array_flip($decoded);
}

$numbers = array_reduce($values, function($c, $v){
   $decoded = identify($v[0]);
   $n = '';
   foreach($v[1] as $item){
       $item = resort($item);
       $n .= $decoded[$item];
   }
   return $c + (int) $n;
}, 0);

echo 'Part 2:'.$numbers.PHP_EOL;