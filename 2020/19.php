<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES); // load file into array

$rules = [];

$i = 0;
while($rule = $values[$i++]){
    list($ind, $rule) = explode(': ', $rule);
    $rules[$ind] = $rule;
}

$messages= array_filter(array_slice($values, $i));
$parsedRules = [];

function parseRule($i){
    global $parsedRules;
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


$parsedRules = [];
$parsedRules[8] = '('.parseRule(42).')+';

//manual recursion 5 times, because it's easier than rewriting to not use regex
$rule11 = '(';
foreach(range(1,5) as $i){
    $rule11.= parseRule(42).'{'.$i.'}'.parseRule(31).'{'.$i.'}|';
}

$parsedRules[11] = rtrim($rule11, '|').')';

$expr = '/^'.parseRule(0).'$/';

$count = count(array_filter($messages, function($v)use($expr){return preg_match($expr, $v);}));

echo "2: $count\n";
