#!/usr/bin/php
<?php

$input = file("input.txt",FILE_IGNORE_NEW_LINES);

if (array_key_exists(1,$argv)) {
	if ($argv[1] == "1") {
		echo part1();
	} elseif ($argv[1] == "2") {
		echo part2();
	} else {
		both();
	}
} else {
	both();
}

function both() {
	echo part1();
	echo "\n";
	echo part2();
}

function part1() {
	global $input;

	$grid = array();
	$overlap = 0;
	foreach ($input as $line) {

		preg_match("/#([0-9]+) @ ([0-9]+),([0-9]+): ([0-9]+)x([0-9]+)/",$line,$matches);
		list(, $id, $left, $top, $width, $height) = $matches;

		for ($y = $top; $y < ($top + $height); $y++) {
			if (!array_key_exists($y, $grid)) { $grid[$y] = array(); }
			for ($x = $left; $x < ($left + $width); $x++) {
				if (!array_key_exists($x, $grid[$y])) { $grid[$y][$x] = 0; }
				$grid[$y][$x]++;
				if ($grid[$y][$x] == 2) {  $overlap++; }
			}
		}
	}
	return $overlap;
}

function part2() {
	global $input;
	return "part 2";
}

echo "\n";

