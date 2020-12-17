<?php

$values = file($argv[1], FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES); // load file into array
$values = array_map('str_split', $values);
$count  = $argv[2] ?? 6;

//everything is 4-dimensional because i just expanded the workspace after solving 1.
function createField(&$map, $x, $y, $z, $w)
{
    if (!isset($map[$w])) {
        $map[$w] = [];
    }

    if (!isset($map[$w][$z])) {
        $map[$w][$z] = [];
    }
    if (!isset($map[$w][$z][$x])) {
        $map[$w][$z][$x] = [];
    }
    if (!isset($map[$w][$z][$x][$y])) {
        $map[$w][$z][$x][$y] = 0;
    }
}

//this will mark activity all around
function markMap(&$map, $x, $y, $z, $w)
{
    foreach ([- 1, 0, 1] as $dw) {
        foreach ([- 1, 0, 1] as $dz) {
            foreach ([- 1, 0, 1] as $dx) {
                foreach ([- 1, 0, 1] as $dy) {
                    if (!$dy && !$dx && !$dz && !$dw) {
                        continue;
                    }
                    createField($map, $x + $dx, $y + $dy, $z + $dz, $w + $dw);
                    $map[$w + $dw][$z + $dz][$x + $dx][$y + $dy] ++;
                }
            }
        }
    }
}

//for the first part, w is always 0, so it's 3 dimensional

//form w, z,x,y
$map = [0 => [0 => $values]];

$i = 0;
while ($i ++ < $count) {
    $activityMap = [];
    foreach ($map[0] as $z => $row) {
        foreach ($row as $x => $column) {
            foreach ($column as $y => $light) {
                //create own space to complete the map
                createField($activityMap, $x, $y, $z, 0);
                if ($light === '#') {
                    markMap($activityMap, $x, $y, $z, 0);
                }
            }
        }
    }

    foreach ($activityMap[0] as $z => $row) {
        foreach ($row as $x => $column) {
            foreach ($column as $y => $activity) {
                createField($map, $x, $y, $z, 0);
                if ($activity === 3) {
                    // 3 always activate
                    $map[0][$z][$x][$y] = '#';
                } elseif ($activity === 2) {
                    // 2 doesn't do anything
                } else {
                    //anything else always inactivates
                    $map[0][$z][$x][$y] = '.';
                }
                if (!$map[0][$z][$x][$y]) {
                    $map[0][$z][$x][$y] = '.';
                }
            }
        }
    }
}
$sum = 0;
foreach ($map[0] as $z => $row) {
    foreach ($row as $x => $column) {
        $sum += array_count_values($column)['#'] ?? 0;
    }
}

echo "1: $sum\n";


//form w, z,x,y
$map = [0 => [0 => $values]];

$i = 0;
while ($i ++ < $count) {
    $activityMap = [];
    foreach ($map as $w => $space) {
        foreach ($space as $z => $row) {
            foreach ($row as $x => $column) {
                foreach ($column as $y => $light) {
                    //create own space to complete the map
                    createField($activityMap, $x, $y, $z, $w);
                    if ($light === '#') {
                        markMap($activityMap, $x, $y, $z, $w);
                    }
                }
            }
        }
    }

    foreach ($activityMap as $w => $space) {
        foreach ($space as $z => $row) {
            foreach ($row as $x => $column) {
                foreach ($column as $y => $activity) {
                    createField($map, $x, $y, $z, $w);
                    if ($activity === 3) {
                        // 3 always activate
                        $map[$w][$z][$x][$y] = '#';
                    } elseif ($activity === 2) {
                        // 2 doesn't do anything
                    } else {
                        //anything else always inactivates
                        $map[$w][$z][$x][$y] = '.';
                    }
                    if (!$map[$w][$z][$x][$y]) {
                        $map[$w][$z][$x][$y] = '.';
                    }
                }
            }
        }
    }
}
$sum = 0;
foreach($map as $w => $space) {
    foreach ($space as $z => $row) {
        foreach ($row as $x => $column) {
            $sum += array_count_values($column)['#'] ?? 0;
        }
    }
}

echo "2: $sum\n";
