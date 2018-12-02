#!/usr/bin/php
<?php

if (array_key_exists(1,$argv)) {
	if ($argv[1] == "1") {
		echo part1();
	} elseif ($argv[1] == "2") {
		echo part2();
	} else {
		echo "Unknown part number";
	}
} else {
	echo "Please choose from part [1] or part [2]";
}

function part1() {
	$file = fopen("input.txt", "r");
	$doubles = 0;
	$triples = 0;

	while ($line = fgets($file)) {
		$table = array();

		$line = str_replace("\n","",$line);
		$array = str_split($line);

		foreach ($array as $letter) {
			$key = ord($letter);

			if (!array_key_exists($key,$table)) {
				$table[$key] = 0;
			}
			$table[$key]++;
		}

		$has_double = false;
		$has_triple = false;

		foreach ($table as $count) {
			if (($count == 2) && (!$has_double)) {
				$has_double = true;
				$doubles++;
			}
			if (($count == 3) && (!$has_triple)) {
				$has_triple = true;
				$triples++;
			}
		}
	}
	fclose($file);
	echo "Doubles: ".$doubles;
	echo "\n";
	echo "Triples: ".$triples;
	echo "\n";
	echo "Checksum: ".($doubles * $triples);
}

function part2() {
	echo "Placeholder";
}


echo "\n";
