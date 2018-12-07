#!/usr/bin/php
<?php

foreach (file('input.txt',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $c) {
	$c = explode(', ', $c);
	$coord[] = ['x' => $c[0], 'y' => $c[1], 'area' => 0];
}

$safe = 0;
$grid = [];
$ignore = [];

$x_max = max(array_column($coord,'x'));
$y_max = max(array_column($coord,'y'));

$x_min = min(array_column($coord,'x'));
$y_min = min(array_column($coord,'y'));

for ($y = $y_min; $y <= $y_max; $y++) {
	for ($x = $x_min; $x <= $x_max; $x++) {
		$grid[$y][$x] = NULL;
		$tmp = [];
		$total = 0;
		foreach ($coord as $k => $p) {
			$x_diff = ($x - $p['x']);
			$y_diff = ($y - $p['y']);

			if($x_diff < 0){
				$x_diff *= -1;
			}
			if($y_diff < 0){
				$y_diff *= -1;
			}
			$taxi = $x_diff + $y_diff;

			$tmp[$k] = $taxi;
			$total += $taxi;
		}
		if ($total < 10000) {
			$safe++;
		}
		$closest = array_keys($tmp, min($tmp));
		if (array_key_exists($closest[0], $ignore)) { continue; }

		if (!array_key_exists(1,$closest)) {
			$coord[$closest[0]]['area']++;
			$grid[$y][$x] = $closest[0];
		}

		//Check for infinite
		if ((($y == $y_min) || ($y == $y_max)) or (($x == $x_min) || ($x == $x_max))) {
			$coord[$closest[0]]['area'] = 0;
			$ignore[$closest[0]] = true;
		}
	}
}

echo max(array_column($coord,'area'));
echo PHP_EOL;

echo $safe;
echo PHP_EOL;

