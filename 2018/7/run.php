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
$finished = false;
$next = '';

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

while (!$finished) {
	$next = key(find_ready($required));
	resolve_dep($next);
}

echo join($resolved);
echo PHP_EOL;

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

function resolve_dep(&$next) {
	global $required, $unlocks, $resolved, $remaining, $finished;

	$pre = count($required[$next]);
	$post = count($unlocks[$next]);

	if (($pre <= 1) and ($post > 0)) {
		$resolved[$next] = $next;

		unset($remaining[$next]);
		unset($required[$next]);

		foreach ($unlocks[$next] as $cleared) {
			unset($required[$cleared][$next]);
		}
	} elseif ($pre == 0 and $post == 0) {
		$resolved[$next] = $next;
		$finished = true;
	}
}


