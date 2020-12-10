<?php
declare(strict_types = 1);


if ($argc == 1) {
    echo '
    Usage: 4.php datafile
     The parameter is the file with the data.
     Echoes the correct final value for both puzzles
    ';
    exit;
}

$values = file(
    $argv[1],
    FILE_IGNORE_NEW_LINES); // load file into array. no FILE_SKIP_EMPTY_LINES since those are record separators

//import
$passports = [];

$record = [];
foreach ($values as $row) {
    //record separator or last line. save and move on
    if (!$row) {
        if ($record) {
            $passports[] = $record;
            $record      = [];
        }
        continue;
    }
    $parts = explode(' ', $row);
    foreach ($parts as $part) {
        [$key, $val] = explode(':', $part);
        $record[$key] = $val;
    }
}

//validate
$fields = [
    'byr',
    'iyr',
    'eyr',
    'hgt',
    'hcl',
    'ecl',
    'pid',
];
$valid1 = 0;
$valid2 = 0;
foreach ($passports as $i => $record) {
    $is_valid_1 = 1;
    $is_valid_2 = 1;
    foreach ($fields as $field) {
        if (!array_key_exists($field, $record)) {
            $is_valid_1 = 0;
            $is_valid_2 = 0;
            break;
        }
        if ($is_valid_2) {
            $value = $record[$field];
            switch ($field) {
                case 'byr':
                    $is_valid_2 = $value >= 1920 && $value <= 2002;
                    break;
                case 'iyr':
                    $is_valid_2 = $value >= 2010 && $value <= 2020;
                    break;
                case 'eyr':
                    $is_valid_2 = $value >= 2020 && $value <= 2030;
                    break;
                case 'hgt':
                    if (strpos($value, 'cm')) {
                        $value      = (int) $value;
                        $is_valid_2 = $value >= 150 && $value <= 193;
                    } else {
                        $value      = (int) $value;
                        $is_valid_2 = $value >= 59 && $value <= 76;
                    }
                    break;
                case 'hcl':
                    $is_valid_2 = preg_match('/^#([0-9]|[a-f]){6}$/', $value);
                    break;
                case 'ecl':
                    $is_valid_2 = in_array($value, ['amb','blu','brn','gry','grn','hzl','oth']);
                    break;
                case 'pid':
                    $is_valid_2 = preg_match('/^[0-9]{9}$/', $value);
                    break;
            }
        }
    }
    $valid1 += $is_valid_1;
    $valid2 += $is_valid_2;
}

echo "1: $valid1\n";
echo "2: $valid2\n";
