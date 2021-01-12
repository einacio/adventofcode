<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$line = array_fill(0,128,' ');
$map = array_fill(0,128, $line);

$sx = $sy = 0;

foreach ($values as $line){
    [$coords, $steps] = explode(' ', $line);
    [$x, $y] = explode(',', $coords);
$map[$y][$x] = '#';
    foreach(explode(',',$steps) as $dir){
        $l = '#';
        switch ($dir){
            case 'U':
                $y --;
                break;
            case 'D':
                $y ++;
                break;
            case 'L':
                $x --;
                break;
            case 'R':
                $x ++;
                break;
            case 'S':
                $sx = $x;
                $sy = $y;
            default:
                $l = $dir;
        }
        $map[$y][$x] = $l;
    }
}

define('X',0);
define('Y',1);
define('ORIGIN',2);
define('PARENT', 3);
$nodesToCheck = [[$sx, $sy, 'S','']];
$nodes = [];
$nodeF='';
while($nodesToCheck){
    $node = array_shift($nodesToCheck);
    $key = $node[X].','.$node[Y];
    if(isset($nodes[$key])){
        continue;
    }
    $nodes[$key] = $node;
    if ($map[$node[Y]][$node[X]] == 'F'){
        $nodeF = $key;
    }
    if($nodeF){
        break;
    }

    if (in_array($map[$node[Y]][$node[X]+1], ['#','F'])){
        $nodesToCheck[] = [Y=>$node[Y], X=>$node[X]+1, 'R', $key];
    }
    if (in_array($map[$node[Y]][$node[X]-1], ['#','F'])){
        $nodesToCheck[] = [Y=>$node[Y], X=>$node[X]-1, 'L', $key];
    }
    if (in_array($map[$node[Y]+1][$node[X]], ['#','F'])){
        $nodesToCheck[] = [Y=>$node[Y]+1, X=>$node[X], 'D', $key];
    }
    if (in_array($map[$node[Y]-1][$node[X]], ['#','F'])){
        $nodesToCheck[] = [Y=>$node[Y]-1, X=>$node[X], 'U', $key];
    }
//    $map[$node[Y]][$node[X]] = '.';

}

$path = '';
$node = $nodes[$nodeF];
while($node[ORIGIN] != 'S'){
    $path.=$node[ORIGIN];
    $map[$node[Y]][$node[X]] = 'P';
    $node = $nodes[$node[PARENT]];
}
$path = strrev($path);

@unlink('mapa.txt');
foreach ($map as $x=>$line){
    file_put_contents('mapa.txt', ' '.implode('', $line)."\n", FILE_APPEND);
}

echo $path."\n";
