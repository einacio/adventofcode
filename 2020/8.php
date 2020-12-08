<?php
if ($argc == 1) {
    echo '
    Usage: 8.php datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

function interpreter($values)
{
    $visited = [];
    $acc = 0;
    $pointer = 0;
    $l = count($values);
    while (true) {
        if (isset($visited[$pointer])) {
            return [false, $acc];
        }
        if($pointer >= $l){
            return [true, $acc];
        }

        $visited[$pointer] = 1;

        list($cmd, $par) = explode(' ', $values[$pointer]);
        switch ($cmd) {
            case 'acc':
                $acc += (int) $par;
            case 'nop':
                $pointer ++;
                break;
            case 'jmp':
                $pointer += (int) $par;
                break;
        }
    }
}

// first one always fail
echo "1: ".interpreter($values)[1]."\n";

foreach ($values as $i => $value){
    // change current instruction
    if($value[0] === 'n'){
        $values[$i] = strtr($value, 'nop', 'jmp');
    }elseif($value[0] === 'j'){
        $values[$i] = strtr($value, 'jmp', 'nop');
    }else{
        continue;
    }

    list($res, $acc) = interpreter($values);
    if($res){
        echo "2: $acc";
        exit;
    }

    // recover previous value for next iteration
    $values[$i] = $value;
    if($value[0] === 'j'){
        $values[$i] = strtr($value, 'nop', 'jmp');
    }elseif($value[0] === 'n'){
        $values[$i] = strtr($value, 'jmp', 'nop');
    }
}

