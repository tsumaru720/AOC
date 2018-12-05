#!/usr/bin/php
<?php

$freq = 0;
$history = [];

$changes = file('input.txt',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

iterate($freq, $changes);
echo $freq;
echo PHP_EOL;

for ($i = 1; true; $i++) {
	reset($history);
	foreach ($history as $f => $seen) {
		$dupe = $f + ($freq * $i);
		if (array_key_exists($dupe, $history)) { break 2; }
	}
}

echo $dupe;
echo PHP_EOL;

function iterate(&$freq, &$changes) {
	global $history;
	$s = count($changes);
	for ($k = 0; $k < $s; $k++) {
		$freq += (int) $changes[$k];
		$history[$freq] = true;
	}
}

