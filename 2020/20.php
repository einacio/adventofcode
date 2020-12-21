<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES); // load file into array


$pieces = [];

function hashSide($value)
{
    $value = strtr($value, ['#' => 1, '.' => 0]);

    return [
        bindec($value),
        bindec(strrev($value))
    ];
}

function createPiece($id, $image)
{
    $piece = [
        'id'           => $id,
        'base_content' => array_map(
            function ($v) {
                return substr($v, 1, - 1);
            }, array_slice($image, 1, - 1)),
        'con'          => ['l' => 0, 't' => 0, 'r' => 0, 'b' => 0],
    ];

    $res               = hashSide($image[0]);
    $piece['top']      = $res[0];
    $piece['top_flip'] = $res[1];

    $res               = hashSide(end($image));
    $piece['bot']      = $res[0];
    $piece['bot_flip'] = $res[1];

    $l = $r = '';
    foreach ($image as $line) {
        $l .= $line[0];
        $r .= $line[strlen($line) - 1];
    }
    $res               = hashSide($l);
    $piece['lef']      = $res[0];
    $piece['lef_flip'] = $res[1];

    $res               = hashSide($r);
    $piece['rig']      = $res[0];
    $piece['rig_flip'] = $res[1];

    return $piece;
}


$i = 0;
while ($i < count($values)) {
    $image = [];
    $id    = (int) explode(' ', $values[$i ++])[1];
    while (@$line = $values[$i ++]) {
        $image[] = $line;
    }
    $pieces[$id] = createPiece($id, $image);
}

$directions = ['top', 'bot', 'lef', 'rig'];
foreach ($pieces as &$pivot) {

    foreach ($pieces as $piece) {
        if ($piece['id'] == $pivot['id']) {
            continue;
        }

        foreach ($directions as $direction) {
            foreach ($directions as $checkDirection) {
                if ($pivot[$direction] == $piece[$checkDirection]) {
                    $pivot['con'][$direction[0]] = $piece['id'];
                }
                if ($pivot[$direction] == $piece[$checkDirection . '_flip']) {
                    $pivot['con'][$direction[0]] = $piece['id'];
                }
            }
        }
    }
}

$tl = '';

$total = 1;
foreach ($pieces as $piece) {
    if (array_reduce(
            $piece['con'], function ($a, $v) {
            return $a + ($v == 0);
        }) == 2) {
        $total *= $piece['id'];
        //take a corner for the second part
        {//if (!($piece['con']['t']) && !($piece['con']['l'])) {
            (!$tl)?$tl = $piece:'';
        }
    }
}

echo "1: $total\n";


$bigImage = [];

$bigImage[0] = [];

$x = 0;
$y = 0;

function rotateImage($source){
    $len = strlen($source[0]);
    $image = array_fill(0, $len, '');
    foreach ($source as $line) {
        foreach (str_split($line) as $i => $char) {
            $image[$len-1-$i] .= $char;
        }
    }
    return $image;
}

function rotatePiece($piece, $l, $t)
{
    while ($piece['con']['l'] != $l) {
        $piece['base_content'] = rotateImage($piece['base_content']);
        $piece['con']          = [
            'l' => $piece['con']['t'],
            't' => $piece['con']['r'],
            'r' => $piece['con']['b'],
            'b' => $piece['con']['l']
        ];
    }

    if ($piece['con']['t'] != $t) {
        $piece['base_content'] = array_reverse($piece['base_content']);
        $tmp                   = $piece['con']['t'];
        $piece['con']['t']     = $piece['con']['b'];
        $piece['con']['b']     = $tmp;
    }

    //this case is lower left corner, where the 0 it finds go on the bottom, but it thinks it found left.
    //so we rotate and do it again
    if($piece['con']['t'] != $t){
        $piece['base_content'] = rotateImage($piece['base_content']);
        $piece['con']          = [
            'l' => $piece['con']['t'],
            't' => $piece['con']['r'],
            'r' => $piece['con']['b'],
            'b' => $piece['con']['l']
        ];
        return rotatePiece($piece, $l, $t);
    }

    return $piece;
}

$t         = 0;
$l         = 0;
$nextPiece = $tl;
while (true) {
    $bigImage[$y][$x] = rotatePiece($nextPiece, $l, $t);
    if (!$bigImage[$y][$x]['con']['r']) {
        $x = 0;
        $l = 0;
        if (!$bigImage[$y][$x]['con']['b']) {
            break;
        }
        $nextPiece = $pieces[$bigImage[$y][$x]['con']['b']];
        $y ++;
        $bigImage[$y] = [];
    } else {
        $nextPiece = $pieces[$bigImage[$y][$x]['con']['r']];
        $l         = $bigImage[$y][$x]['id'];
        $x ++;
    }
    $t = $y ? $bigImage[$y - 1][$x]['id'] : 0;
}

$renderedImage = [];
foreach ($bigImage as $row) {
    foreach (range(0, count($row[0]['base_content']) - 1) as $i) {
        $line = '';
        foreach ($row as $column) {
            $line .= $column['base_content'][$i];
        }
        $renderedImage[] = $line;
    }
}
$linebreak = strlen($renderedImage[0]) - 20;

$pattern = '/#..{'.$linebreak.'}#.{4}##.{4}##.{4}###.{'.$linebreak.'}.#..#..#..#..#..#/';

//$renderedImage = array_reverse($renderedImage);
//$renderedImage = rotateImage($renderedImage);
//$renderedImage = rotateImage($renderedImage);
//$renderedImage = rotateImage($renderedImage);
echo implode("\n", $renderedImage);
$test = implode('',$renderedImage);
var_dump(preg_match_all($pattern, $test));
$j = 5;
$counts=[];
while($j--){
    $i = 4;
    while($i--) {
        $test = implode('', $renderedImage);
        var_dump(count_chars($test)[ord('#')]);
        if ($count = preg_match_all($pattern, $test)) {
            break 2;
        }
        $renderedImage = rotateImage($renderedImage);
    }
    $renderedImage = array_reverse($renderedImage);
}
$count = count_chars($test)[ord('#')] - ($count * 15);

//echo implode("\n", $renderedImage);
$test = implode('',$renderedImage);
var_dump(preg_match_all($pattern, $test));
var_dump($pattern);
echo "2: $count\n";

echo count($pieces).' '.count($renderedImage).' '.strlen($renderedImage[0]);
