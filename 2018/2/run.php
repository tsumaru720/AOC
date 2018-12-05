#!/usr/bin/php
<?php

$input = file('input.txt',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

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
echo ($doubles * $triples);
echo PHP_EOL;

reset($input);

$str_len = strlen($input[0]);
$halfway = ($str_len/2);

foreach ($input as $k => $entry) {
	$search = str_split($entry,$halfway);

	// we wont need this again
	unset($input[$k]);

	$one = str_split($entry);

	foreach ($input as $target) {
		$test = str_split($target,$halfway);

		if (($test[0] === $search[0]) xor ($test[1] === $search[1])) {

			$r = checkdiff($test[1], $search[1]);
			if ($r > 1) { continue; }
			$l = checkdiff($test[0], $search[0]);

			if (($l+$r) === 1) {
				//Should only be one of these
				foreach ($one as $i => $letter) {
					if ($letter != $target{$i}) {
						$errant_pos = $i;
						break;
					}
				}
				$one[$errant_pos] = '';
				$result = join($one);
				break 2;
			}
		}
	}
}
echo $result;
echo PHP_EOL;

function checkdiff(&$a, &$b) {
	global $halfway;
	$s = $halfway;
	$d = 0;
	for ($i = 0; $i < $s; $i++) {
		if ($a{$i} !== $b{$i}) {
			$d++;
		}
		if ($d > 1) {
			return $d;
		}
	}
	return $d;
}