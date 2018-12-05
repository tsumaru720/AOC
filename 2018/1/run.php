#!/usr/bin/php
<?php

$freq = 0;
$history = [];
$dupe = 0;

$changes = file('input.txt',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

iterate($freq, $changes);
echo $freq;
echo PHP_EOL;

while ($dupe === 0) {
	iterate($freq, $changes);
}
echo $dupe;
echo PHP_EOL;

function iterate(&$freq, &$changes) {
	global $history, $dupe;
	$s = count($changes);
	for ($k = 0; $k < $s; $k++) {
		$freq += (int) $changes[$k];

		if (array_key_exists($freq, $history)) {
			$dupe = $freq;
			break;
		}

		$history[$freq] = true;
	}
}
