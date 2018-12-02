#!/usr/bin/php
<?php

if (array_key_exists(1,$argv)) {
	if ($argv[1] == "1") {
		echo "Checksum: ".part1();
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
	return ($doubles * $triples);
}

function part2() {
//	$file = fopen("part2_test.txt", "r");
	$file = fopen("input.txt", "r");

	while ($line = fgets($file)) {
                $line = str_replace("\n","",$line);
		$table[] = $line;
	}

	foreach ($table as $entry) {

		$halfway = (strlen($entry)/2);
		$search[0] = substr($entry,0,$halfway);
		$search[1] = substr($entry,$halfway);

		foreach ($table as $key => $target) {
			if ($target == $entry) { continue; }

			$test[0] = substr($target,0,$halfway);
			$test[1] = substr($target,$halfway);

			if ((($test[0] == $search[0]) && ($test[1] != $search[1])) || (($test[0] != $search[0]) && ($test[1] == $search[1]))) {
				//Should only be one of these
				$difference = 0;
				$one = str_split($entry);
				$two = str_split($target);
				foreach ($one as $i => $letter) {
					if ($letter != $two[$i]) {
						$difference++;
						$errant_pos = $i;
					}
				}
				if ($difference == 1) {
					$one[$errant_pos] = "";
					$result = join($one);
					break;
				}
			}
		}

		if (isset($result)) { break; }
	}

	fclose($file);
	return $result;
}


echo "\n";
