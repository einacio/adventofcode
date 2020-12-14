<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array


$x      = 0;
$y      = 0;
$curDir = 'E';

function calculate($order)
{
    global $curDir;
    $direction = $order[0];
    $value     = substr($order, 1);
    $x         = 0;
    $y         = 0;
    switch ($direction) {
        case 'E':
            $x += $value;
            break;
        case 'W':
            $x -= $value;
            break;
        case 'N':
            $y -= $value;
            break;
        case 'S':
            $y += $value;
            break;
        case 'F':
            return calculate($curDir.$value);
        case 'R':
            $directions = ['E','S','W','N','E','S','W','N'];
            $value = $value / 90;
            $curPos = array_search($curDir, $directions);
            $curDir = $directions[$curPos+$value];
            break;
        case 'L':
            $directions = ['E','N','W','S','E','N','W','S'];
            $value = $value / 90;
            $curPos = array_search($curDir, $directions);
            $curDir = $directions[$curPos+$value];
            break;
    }

    return ['x' => $x, 'y' => $y];
}


foreach ($values as $value) {
    $res = calculate($value);
    $x += $res['x'];
    $y += $res['y'];
}

echo "1: ".(abs($x)+abs($y))."\n";

// part 2, calculate will move the waypoint

function waypointCalculate($order){
    static $waypoint = ['x'=>10, 'y'=>-1];
    $direction = $order[0];
    $value     = substr($order, 1);
    $x         = 0;
    $y         = 0;
    if($direction === 'F'){
        $x = $value;
        $y = $value;
    }elseif ($direction === 'R' || $direction === 'L'){
        $value = $value/90;
        if($direction === 'L'){
            $value = 4 - $value;
        }
        switch ($value){
            case 1:
                $waypoint = ['x' => -$waypoint['y'], 'y' => $waypoint['x']];
                break;
            case 2:
                $waypoint = ['x' => -$waypoint['x'], 'y' => -$waypoint['y']];
                break;
            case 3:
                $waypoint = ['x' => $waypoint['y'], 'y' => -$waypoint['x']];
                break;
        }
    }else{
        $tmp = calculate($order);
        $waypoint['x'] +=$tmp['x'];
        $waypoint['y'] += $tmp['y'];
    }
    return ['x' => $x * $waypoint['x'], 'y' => $y * $waypoint['y']];
}

$x = $y = 0;
foreach ($values as $value) {
    $res = waypointCalculate($value);
    $x += $res['x'];
    $y += $res['y'];
}

echo "2: ".(abs($x)+abs($y))."\n";
