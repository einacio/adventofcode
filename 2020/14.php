<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array

$memory = [];
$memory2 = [];
$currentMask = [];

foreach ($values as $line){
    list($command, $value) = explode(' = ', $line);
    if($command === 'mask'){
        $currentMask = str_split($value);
    }else{
        $pos = (int) substr($command,4);
        $tmp = str_pad(base_convert($value, 10, 2), 36, '0', STR_PAD_LEFT);
        foreach ($currentMask as $i=>$bit){
            if($bit !== 'X')
                $tmp[$i] = $bit;
        }
        $memory[$pos] = base_convert($tmp, 2, 10);

        $tmp = str_split(str_pad(base_convert($pos, 10, 2), 36, '0', STR_PAD_LEFT));
        foreach ($currentMask as $i=>$bit){
            if($bit !== '0')
                $tmp[$i] = $bit;
        }
        $addresses = [''];
        foreach ($tmp as $bit){
            if($bit !== 'X'){
                foreach ($addresses as $i=>$address){
                    $addresses[$i] .= $bit;
                }
            }else{
                $tmpAddress = [];
                foreach ($addresses as $address){
                    $tmpAddress[] = $address.'1';
                    $tmpAddress[] = $address.'0';
                }
                $addresses = $tmpAddress;
            }
        }
        foreach ($addresses as $address){
            $memory2[$address] = $value;
        }

    }
}

$total = array_sum($memory);
$total2 = array_sum($memory2);
echo "1: $total\n";
echo "2: $total2\n";
