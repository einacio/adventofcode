<?php
require_once __DIR__ . '/../functions/functions.php';

prelude();

$values = in();

//part 1

$numbers = [];

foreach ($values as $line) {
    //array_values is to reset the keys
    $line = array_values(array_filter(str_split($line, 1), 'ctype_digit'));
    $numbers[] = $line[0] . $line[count($line) - 1];
}

out(array_sum($numbers));

//part 2

$numbers = [];

$replacements =
    //this one is tricky. numbers can be overlapped
    //example twone. it counts as 2 from the beginning, and as 1 from the end
    //we leave enough letters to be able to chain into other number name
    //the combinations are finite, we could as well add them first
    [
        'one' => 'o1e', //allow twone and oneight
        'two' => 't2o', //allow eightwo and twone
        'three' => 'th3e', //eighthree and threeight
        'four' => '4', //no number starting with r or ending in f
        'five' => '5e', //fiveight
        'six' => '6', //as 4
        'seven' => '7n', //sevenine
        'eight' => 'e8t', //fiveight, threeight, eightwo, eighthree, nineight
        'nine' => 'n9e', //sevenine, nineight
    ];

foreach ($values as $line) {
    debug($line);
    foreach ($replacements as $f => $t) {
        $line = str_replace($f, $t, $line);
    }
    debug($line);

    //array_values is to reset the keys
    $line = array_values(array_filter(str_split($line, 1), 'ctype_digit'));
    $numbers[] = $line[0] . $line[count($line) - 1];

    debug(
        implode('', $line) . PHP_EOL .
        $line[0] . $line[count($line) - 1] . PHP_EOL
    );

}

out(array_sum($numbers));