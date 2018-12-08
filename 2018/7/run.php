#!/usr/bin/php
<?php

$required = [];
$unlocks = [];
$resolved = [];
$remaining = [];
$worker = [];
$num_workers = 0;
$finished = false;

$time = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0, 'E' => 0, 'F' => 0, 'G' => 0,
	'H' => 0, 'I' => 0, 'J' => 0, 'K' => 0, 'L' => 0, 'M' => 0, 'N' => 0,
	'O' => 0, 'P' => 0, 'Q' => 0, 'R' => 0, 'S' => 0, 'T' => 0, 'U' => 0,
	'V' => 0, 'W' => 0, 'X' => 0, 'Y' => 0, 'Z' => 0];

foreach (file('input.txt',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $inst) {
	$c = explode(' ', $inst);
	//1 and 7

	$a = $c[1];
	$b = $c[7];

	$required[$b][$a] = $a;
	$unlocks[$a][$b] = $b;

	if (!array_key_exists($a,$required)) {
		$required[$a] = [];
	}
	if (!array_key_exists($b,$unlocks)) {
		$unlocks[$b] = [];
	}
}
$copy_required = $required;
$copy_unlocks = $unlocks;

init_workers(1);
echo iterate(1);
echo PHP_EOL;

$required = $copy_required;
$unlocks = $copy_unlocks;
$time = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7,
	'H' => 8, 'I' => 9, 'J' => 10, 'K' => 11, 'L' => 12, 'M' => 13, 'N' => 14,
	'O' => 15, 'P' => 16, 'Q' => 17, 'R' => 18, 'S' => 19, 'T' => 20, 'U' => 21,
	'V' => 22, 'W' => 23, 'X' => 24, 'Y' => 25, 'Z' => 26];

init_workers(5);
iterate(60);
echo $elapsed;
echo PHP_EOL;

function iterate($interval) {
	global $required, $elapsed, $remaining, $resolved, $finished, $step, $num_workers;

	$step = $interval;
	$elapsed = -1;

	$resolved = [];
	$remaining = [];
	$finished = false;
	while (!$finished) {
		fill_workers(find_ready($required));
		if (idle_workers() === $num_workers) { $finished = true; }
	}

	return join($resolved);
}

function find_ready(&$required) {
	global $remaining;
	foreach ($required as $k => $v) {
		if (empty($v)) {
			$remaining[$k] = $k;
		}
	}
	ksort($remaining);
	return $remaining;
}

function init_workers($count) {
	global $worker, $num_workers;

	$num_workers = $count;
	$worker = [];
	for ($w = 0; $w < $count; $w++) {
		$worker[$w] = ['task' => '', 'time' => 0, 'elapsed' => 0];
	}
}

function idle_workers() {
	global $worker;

	$idle = 0;
	foreach ($worker as $w => $v) {
		if ($worker[$w]['task'] === '') {
			$idle++;
		}
	}
	return $idle;

}

function fill_workers($ready) {
	global $worker, $required, $time, $step, $elapsed, $remaining;

	// Finish tasks
	foreach ($worker as $w => $v) {
		if ($worker[$w]['task'] != '') {
			$worker[$w]['elapsed']++;
			if ($worker[$w]['elapsed'] == $worker[$w]['time']) {
				resolve_dep($worker[$w]['task']);
				$ready = array_merge($ready, find_ready($required));
				ksort($ready);
				$worker[$w]['task'] = '';
				$worker[$w]['time'] = 0;
				$worker[$w]['elapsed'] = 0;
			}
		}
	}
	// Start new tasks in available workers
	foreach ($worker as $w => $v) {
		if ($worker[$w]['task'] === '') {
			if (count($ready) > 0) {
				$next = key($ready);
				unset($ready[$next]);
				unset($required[$next]);
				unset($remaining[$next]);
				$worker[$w]['task'] = $next;
				$worker[$w]['time'] = $time[$next] + $step;
			}
		}
	}
	$elapsed++;
/*
	global $resolved;
	echo $elapsed."\t";

	foreach ($worker as $w => $v) {
		echo ($worker[$w]['task'] === '' ? '.' : $worker[$w]['task'])." ";
	}
	echo "\t".join($resolved);
	echo PHP_EOL;*/
}


function resolve_dep($next) {
	global $required, $unlocks, $resolved, $remaining, $finished;

	$unlocked = count($unlocks[$next]);
	if ($unlocked > 0) {
		$resolved[$next] = $next;

		unset($remaining[$next]);
		unset($required[$next]);

		foreach ($unlocks[$next] as $cleared) {
			unset($required[$cleared][$next]);
		}
	} else {
		$resolved[$next] = $next;
		unset($remaining[$next]);
		unset($required[$next]);
	}
}
