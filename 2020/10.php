<?php
if ($argc == 1) {
    echo '
    Usage: 10.php datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array
$values[]='0';
sort($values);
$pieces = array_combine($values, array_fill(0,count($values), 0));
$pieces[0] = 1;
$counts = [0=>0, 1=>0, 3=>1]; //include last step
$prev = 0;
foreach ($pieces as $value=>$comb){
    $diff = $value - $prev;
    $counts[$diff]++;
    $prev = $value;

    //combination for a piece is the sum of the possible combinations for the previous in the link
    if(isset($pieces[$value-1])){
        $comb+=$pieces[$value-1];
    }
    if(isset($pieces[$value-2])){
        $comb+=$pieces[$value-2];
    }
    if(isset($pieces[$value-3])){
        $comb+=$pieces[$value-3];
    }
    $pieces[$value] = $comb;
}
echo "1 ".($counts[1]*$counts[3])."\n";

$total2 = end($pieces);

echo "2 $total2\n";
