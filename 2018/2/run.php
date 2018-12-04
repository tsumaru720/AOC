#!/usr/bin/php
<?php

$input = file("input.txt",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

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

		$table = count_chars($line,1);
		$table = array_count_values($table);

		if (array_key_exists(2,$table)) {
			$doubles++;
		}

		if (array_key_exists(3,$table)) {
			$triples++;
		}

	}
	return ($doubles * $triples);
}

function part2() {
	global $input;

	foreach ($input as $k => $entry) {

		$halfway = (strlen($entry)/2);

		$search = str_split($entry,$halfway);

		// we wont need this again
		unset($input[$k]);

		$one = str_split($entry);

		foreach ($input as $target) {
			$test = str_split($target,$halfway);

			if (($test[0] == $search[0]) xor ($test[1] == $search[1])) {
				if ((levenshtein($test[0],$search[0]) == 1) xor (levenshtein($test[1],$search[1]) == 1)) {
					//Should only be one of these
	                                foreach ($one as $i => $letter) {
	                                        if ($letter != $target{$i}) {
	                                                $errant_pos = $i;
	                                                break;
	                                        }
	                                }
	                                $one[$errant_pos] = "";
	                                $result = join($one);
	                                break 2;
				}
			}
		}
	}
	return $result;
}
echo "\n";
