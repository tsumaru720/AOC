#!/usr/bin/php
<?php
ini_set('memory_limit','-1');

$input = file("input.txt",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$results = iterate();

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

function iterate() {
	global $input;

	$grid = array();
	$id_overlaps = array();
	$overlap = 0;

	foreach ($input as $line) {

		preg_match("/#([0-9]+) @ ([0-9]+),([0-9]+): ([0-9]+)x([0-9]+)/",$line,$matches);
		list(, $id, $left, $top, $width, $height) = $matches;
		$id_overlaps[$id] = false;

		for ($y = $top; $y < ($top + $height); $y++) {

			if (!array_key_exists($y, $grid)) { $grid[$y] = array(); }
			for ($x = $left; $x < ($left + $width); $x++) {

				if (!array_key_exists($x, $grid[$y])) { $grid[$y][$x] = array(); }
				$grid[$y][$x][] = $id;
				$count = count($grid[$y][$x]);
				if ($count == 2) {
					$overlap++;
				 }
				if ($count >= 2) {
					foreach ($grid[$y][$x] as $update) {
						$id_overlaps[$update] = true;
					}
				 }
			}
		}
	}
	return array($overlap,array_search(false, $id_overlaps));

}

function part1() {
	global $results;
	return $results[0];
}

function part2() {
	global $results;
	return $results[1];
}


echo "\n";

