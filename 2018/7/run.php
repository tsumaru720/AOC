#!/usr/bin/php
<?php

/*
Only C is available, and so it is done first.
Next, both A and F are available. A is first alphabetically, so it is done next.
Then, even though F was available earlier, steps B and D are now also available, and B is the first alphabetically of the three.
After that, only D and F are available. E is not available because only some of its prerequisites are complete. Therefore, D is completed next.
F is the only choice, so it is done next.
Finally, E is completed.

So, in this example, the correct order is CABDFE.
*/

$required = [];
$unlocks = [];
$resolved = [];
$remaining = [];
$worker = [];
$finished = false;

$time = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7,
	'H' => 8, 'I' => 9, 'J' => 10, 'K' => 11, 'L' => 12, 'M' => 13, 'N' => 14,
	'O' => 15, 'P' => 16, 'Q' => 17, 'R' => 18, 'S' => 19, 'T' => 20, 'U' => 21,
	'V' => 22, 'W' => 23, 'X' => 24, 'Y' => 25, 'Z' => 26];

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

init_workers(1, $worker);
echo iterate();
echo PHP_EOL;

$required = $copy_required;
$unlocks = $copy_unlocks;

init_workers(5, $worker);
iterate(5, 60);
echo $elapsed;
echo PHP_EOL;

function iterate($worker_count = 1, $interval = 1) {
	global $required, $elapsed, $remaining, $resolved, $finished, $step;

	$step = ($interval);
	$elapsed = -1;

	$resolved = [];
	$remaining = [];
	$finished = false;
	while (!$finished) {
		fill_workers(find_ready($required));
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

function init_workers($count, &$worker) {
	$worker = [];
	for ($w = 0; $w < $count; $w++) {
		$worker[$w] = ['task' => '', 'time' => 0, 'elapsed' => 0];
	}
}

function fill_workers($ready) {
	global $worker, $required, $time, $step, $elapsed, $remaining;
	global $resolved;

	$elapsed++;
	foreach ($worker as $w => $v) {
		if ($worker[$w]['task'] != '') {
			$worker[$w]['elapsed']++;
			if ($worker[$w]['elapsed'] >= $worker[$w]['time']) {
				resolve_dep($worker[$w]['task']);
				$ready = array_merge($ready, find_ready($required));
				ksort($ready);
				$worker[$w]['task'] = '';
				$worker[$w]['time'] = 0;
				$worker[$w]['elapsed'] = 0;
			}
		}
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
	/*
	echo $elapsed."\t";

	foreach ($worker as $w => $v) {
		echo ($worker[$w]['task'] === '' ? '.' : $worker[$w]['task'])."\t";
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
		$finished = true;
	}
}
