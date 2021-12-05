<?php
if ($argc == 1) {
    echo '
    Usage: '.__FILE__.' datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$lines = [];
foreach ($values as $value) {
    list($part1, $part2) = explode(' -> ', $value);
    $line = [explode(',',$part1), explode(',',$part2)];
    if($line[0][0] < $line[1][0]){
        $line = [$line[1], $line[0]];
    }
    $lines[] = $line;
}

$l1 = array_filter($lines, function($v){
    return ($v[0][0] == $v[1][0] || $v[0][1] == $v[1][1]);
});

$map = [];

foreach($l1 as $line){
    if($line[0][0] == $line[1][0]){
        $x = $line[0][0];
        if(!isset($map[$x])){
            $map[$x] = [];
        }
        foreach(range($line[0][1], $line[1][1]) as $y){
            if(isset($map[$x][$y])){
                $map[$x][$y]++;
            }else{
                $map[$x][$y] = 1;
            }
        }
    }else{
        $y = $line[0][1];
        foreach(range($line[0][0], $line[1][0]) as $x){
            if(!isset($map[$x])){
                $map[$x] = [];
            }
            if(isset($map[$x][$y])){
                $map[$x][$y]++;
            }else{
                $map[$x][$y] = 1;
            }
        }
    }
}

$t = 0;
array_walk_recursive($map, function($v)use(&$t){if($v>1){$t++;}});
echo 'Part 1: '.$t.PHP_EOL;

foreach($lines as $line){
    list($x1, $y1) = $line[0];
    list($x2, $y2) = $line[1];
    if($x1 != $x2 && $y1 != $y2){
        $op = ($y1 > $y2)?-1:1;
        $y = $y1;
        foreach(range($x1, $x2) as $x){
            if(!isset($map[$x])){
                $map[$x] = [];
            }
            if(isset($map[$x][$y])){
                $map[$x][$y]++;
            }else{
                $map[$x][$y] = 1;
            }
            $y += $op;
        }
    }
}

$t = 0;
array_walk_recursive($map, function($v)use(&$t){if($v>1){$t++;}});
echo 'Part 2: '.$t.PHP_EOL;