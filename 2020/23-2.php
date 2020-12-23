<?php

$values = str_split($argv[1]);

//Using linked list, from suggestions on reddit
//List algorithm from part 1 would have taken 4 days to finish
$prev = null;
$list = [];
$current = reset($values);
foreach($values as $val){
    $list[$val] = $current;
    if($prev){
        $list[$prev] = $val;
    }
    $prev = $val;
}
$val = max($values);
while ($val < 1000000){
    $val++;
    $list[$val] = $current;
    $list[$prev] = $val;
    $prev = $val;
}

$max = 1000000;

$iter = 10000000;
while ($iter--){
    $n1 = $list[$current];
    $n2 = $list[$n1];
    $n3 = $list[$n2];

    $destination = $current;
    $found = false;
    while (!$found){
        $destination--;
        if(!$destination){
            $destination = $max;
        }
        $found = ($destination != $n1 && $destination != $n2 && $destination != $n3);
    }
    $next = $list[$n3];
    $list[$current] = $next;

    $splice = $list[$destination];
    $list[$n3] = $splice;
    $list[$destination] = $n1;

    $current = $next;
}

$n1 = $list[1];
$n2 = $list[$n1];

echo '2: '.($n1* $n2)."\n";
