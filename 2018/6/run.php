#!/usr/bin/php
<?php

foreach (file("input.txt",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $c) {
	$c = explode(', ', $c);
	$coord[] = ['x' => $c[0], 'y' => $c[1], 'area' => 0];
}

$safe = 0;

$x_max = max(array_column($coord,'x'));
$y_max = max(array_column($coord,'y'));

for ($y = 0; $y <= $y_max; $y++) {
	for ($x = 0; $x <= $x_max; $x++) {
		$grid[$y][$x] = NULL;
		$tmp = [];
		foreach ($coord as $k => $p) {
			$x_diff = ($x - $p['x']);
			$y_diff = ($y - $p['y']);
			$taxi = abs($x_diff) + abs($y_diff);

			$tmp[$k] = $taxi;
		}
		if (array_sum($tmp) < 10000) {
			$safe++;
		}
		asort($tmp);
		reset($tmp);
		$closest = key($tmp);
		$values = array_count_values($tmp);

		if ($values[$tmp[$closest]] < 2) {
			$coord[$closest]['area']++;
			$grid[$y][$x] = $closest;
		}

	}
}

// Invalidate infinite
for ($y = 0; $y <= $y_max; $y++) {
	$min = $grid[$y][0];
	$max = $grid[$y][$x_max];

	$coord[$min]['area'] = 0;
	$coord[$max]['area'] = 0;
}

for ($x = 0; $x <= $x_max; $x++) {
	$min = $grid[0][$x];
	$max = $grid[$y_max][$x];

	$coord[$min]['area'] = 0;
	$coord[$max]['area'] = 0;
}



echo max(array_column($coord,'area'));
echo PHP_EOL;

echo $safe;
echo PHP_EOL;


/*
die();
// DISPLAY SHIT
foreach ($coord as $k => $p) {
	//$grid[$p['y']][$p['x']] = str_pad($k,2,'0',STR_PAD_LEFT);
	$grid[$p['y']][$p['x']] = chr(48+$k);
}

foreach ($grid as $y => $v) {
	foreach ($v as $x => $v2) {
		echo $v2;
	}
	echo PHP_EOL;
	
} */

//$distance = abs($x_dist)+abs($y_dist);

