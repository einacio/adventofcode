<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES); // load file into array

$rules = [];

$i = 0;
while($rule = $values[$i++]){
    list($ind, $rule) = explode(': ', $rule);
    $rules[$ind] = $rule;
}

$messages= array_filter(array_slice($values, $i));


function parseRule($i){
    static $parsedRules = [];
    global $rules;
    if(!isset($parsedRules[$i])){
        if($rules[$i][0] == '"'){
            $parsedRules[$i] = trim($rules[$i], '"');
        }else{
            $parts = explode(' ', $rules[$i]);
            $isOr = false;
            $rule = '';
            foreach ($parts as $part){
                if($part != '|'){
                    $rule .= parseRule($part);
                }else{
                    $isOr = true;
                    $rule .= '|';
                }
            }
            if($isOr){
                $rule = "($rule)";
            }
            $parsedRules[$i] = $rule;
        }
    }

    return $parsedRules[$i];
}

$expr = '/^'.parseRule(0).'$/';

$count = count(array_filter($messages, function($v)use($expr){return preg_match($expr, $v);}));

echo "1: $count\n";
