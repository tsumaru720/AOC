#!/usr/bin/php
<?php

//$start = microtime(true);
$input = file("input.txt",FILE_IGNORE_NEW_LINES);

if (array_key_exists(1,$argv)) {
	if ($argv[1] == "1") {
		echo part1();
	} elseif ($argv[1] == "2") {
		echo part2();
	} elseif ($argv[1] == "both") {
		echo part1();
		echo "\n";
		echo part2();
	} else {
		echo "Unknown part number";
	}
} else {
	echo "Please choose from part [1] or part [2]";
}

function part1() {
	global $input;
	$doubles = 0;
	$triples = 0;

	foreach ($input as $line) {
		$array = str_split($line);
		$table = array_count_values($array);

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
	return ($doubles * $triples);
}

function part2() {
//	$table = file("input.txt",FILE_IGNORE_NEW_LINES);
	global $input;

//	$table = $input;
	foreach ($input as $k => $entry) {

		$halfway = (strlen($entry)/2);
		$search[0] = substr($entry,0,$halfway);
		$search[1] = substr($entry,$halfway);

		// we wont need this again
		unset($input[$k]);

		$one = str_split($entry);

		foreach ($input as $target) {

			$test[0] = substr($target,0,$halfway);
			$test[1] = substr($target,$halfway);

			if ((($test[0] == $search[0]) && ($test[1] != $search[1])) || (($test[0] != $search[0]) && ($test[1] == $search[1]))) {
				//Should only be one of these
				$difference = 0;
				$two = str_split($target);
				foreach ($one as $i => $letter) {
					if ($letter != $two[$i]) {
						$difference++;
						if ($difference > 1) { break; }
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

	return $result;
}

echo "\n";

//$time_elapsed_secs = microtime(true) - $start;
//echo "(".number_format($time_elapsed_secs,4)."s)\n";
