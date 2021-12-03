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

$positions = array_fill(0, strlen($values[0]), []);

foreach($values as $line){
    $digits =  str_split($line, 1);
//    var_dump($digits, $line);exit;
    foreach($digits as $i => $digit){
        $positions[$i][$digit] +=1;
    }
}
$g = $e = '';
foreach ($positions as $position){
    if($position[0]>$position[1]){
        $g.='0';
        $e.='1';
    }else{
        $g.='1';
        $e.='0';
    }
}

$g = bindec($g);
$e = bindec($e);

echo 'Part 1: '.($g*$e).PHP_EOL;

$o = $values;
$op = $positions;
$current_bit = 0;
while(count($o)>1){
    $o = array_filter($o, function($val) use($current_bit, $op){
        $n = ($op[$current_bit][0]>$op[$current_bit][1])?0:1;
        return $val[$current_bit] == $n;
    });
    $op = array_fill(0, strlen($values[0]), []);
    foreach($o as $line){
        $digits =  str_split($line, 1);
        foreach($digits as $i => $digit){
            $op[$i][$digit] +=1;
        }
    }
    $current_bit++;
}
$o = reset($o);

$c = $values;
$cp = $positions;
$current_bit = 0;
while(count($c)>1){
    $c = array_filter($c, function($val) use($current_bit, $cp){
        $n = ($cp[$current_bit][0]>$cp[$current_bit][1])?1:0;
        return $val[$current_bit] == $n;
    });
    $cp = array_fill(0, strlen($values[0]), []);
    foreach($c as $line){
        $digits =  str_split($line, 1);
        foreach($digits as $i => $digit){
            $cp[$i][$digit] +=1;
        }
    }
    $current_bit++;
}
$c = reset($c);

echo 'Part 2: '.(bindec($o)*bindec($c)).PHP_EOL;