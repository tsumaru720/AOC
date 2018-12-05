#!/usr/bin/php
<?php

$freq = 0;
$changes = file('input.txt',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

iterate($freq, $changes);
echo $freq;
echo PHP_EOL;

function iterate(&$freq, &$changes) {
	$s = count($changes);
	for ($k = 0; $k < $s; $k++) {
		$freq += (int) $changes[$k];
	}
}
