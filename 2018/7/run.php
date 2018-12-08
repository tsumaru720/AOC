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

$prereq = [];
$unlocks = [];
$resolved = [];
$remaining = [];
$start = '';
//$last_resolved = '';

foreach (file('input.txt',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $inst) {
	$c = explode(' ', $inst);
	//1 and 7

	$a = $c[1];
	$b = $c[7];

	if ($start === '') { $start = $a; }
	
	$prereq[$b][$a] = $a;
	$unlocks[$a][$b] = $b;
	
	if (!array_key_exists($a,$prereq)) {
		$prereq[$a] = [];
	}
	if (!array_key_exists($b,$unlocks)) {
		$unlocks[$b] = [];
	}
}

$next_step = $start;
$finished = false;
$i=0;
while (!$finished) {
	/*if ($i > 10) { 
		var_dump($prereq);
		//var_dump($resolved);
		break;
	}
	$i ++;*/
	
	ksort($prereq[$next_step]);
	resolve_dep($next_step);

}
echo join($resolved);
echo PHP_EOL;



function resolve_dep(&$next_step) {
	global $prereq, $unlocks, $resolved, $finished;

	$last_resolved = array_key_last($resolved);
echo 'Trying to resolve '.$next_step. ' dependencies';

/*if ($next_step == 'E' and array_key_exists('D',$resolved) and array_key_exists('F',$resolved)) {

	//echo PHP_EOL;
	echo ' ... Stopped on: '. $next_step;
	echo PHP_EOL;
	echo '>>> Current Order: ';
	foreach ($resolved as $r) {
		echo $r;
	}
	
	echo PHP_EOL;
	

	var_dump($prereq[$next_step]);
	var_dump($unlocks[$next_step]);
	die();
}*/

	$pre = count($prereq[$next_step]);
	$post = count($unlocks[$next_step]);
	
	if (($pre <= 1) and ($post > 0)) {
		echo ' ... Done';

		$resolved[$next_step] = $next_step;
		$last_resolved = $next_step;

		ksort($unlocks[$next_step]);
		$next_step = array_key_first($unlocks[$next_step]);

		foreach ($unlocks[$last_resolved] as $cleared) {
			unset($prereq[$cleared][$last_resolved]);
		}
		
		//unset($prereq[$next_step][$last_resolved]);
	} elseif ($pre == 0 and $post == 0) {
		echo ' ... Done';
		$resolved[$next_step] = $next_step;
		$finished = true;
	} else {
		echo ' ... Cant.. Moving on to ';
		$plan_b = array_key_first($prereq[$next_step]);
		
		unset($unlocks[$last_resolved][$next_step]);
		$next_step = array_key_first($unlocks[$last_resolved]);
		if ($next_step == '') {
			$next_step = $plan_b;
		}
		echo $next_step;
		//var_dump('next '.$next_step);
		//var_dump($prereq[$next_step]);
	}
echo PHP_EOL;
}













/*
$seq .= follow($remainder);
var_dump($seq);

$i = 0;

function follow(&$remainder) {
	global $i;
	global $next_steps, $last;
	
	//if ($i > 5) { die(); }
	$i++;

	ksort($remainder);
	var_dump($remainder);
	if (empty($remainder)) {
		return $last;
	}
	

	
	$seq = array_key_first($remainder);
	unset($remainder[$seq]);
	$remainder = array_merge($remainder,$next_steps[$seq]);
	if (empty($next_steps[$seq])) {
		$last = $seq;
		$seq = '';
	}
	
	
 	//var_dump($seq);
	//var_dump($next_steps[$seq]);
	
	//if (!empty($remainder)) {
		$seq .= follow($remainder);
		return $seq;
	//} else
	

}
*/



















/*
die();
$seq = key($next_step);
$remainder = $next_step[$seq];
$last = '';

$seq .= follow($remainder);
var_dump($seq);




function follow(&$remainder) {
	global $next_step, $last;
	
	ksort($remainder);
	
	$seq = key($remainder);
	unset($remainder[$seq]);

	if (array_key_exists($seq, $next_step)) {
		//unset($remainder[$seq]);
		$remainder = array_merge($remainder,$next_step[$seq]);
		$seq .= follow($remainder);

	} else {
		$last = $seq;

		$seq = key($remainder);
		$seq .= $last;

	}
	
	return $seq;
	

}*/

//----------------

/*$seq = '';
$next = '';
$todo = [];
foreach ($next_step as $a => $b) {
	ksort($b);
	if ($seq === '') {
		$seq .= $a;
	}
	
	foreach ($b as $k => $v) {
		if ($next === '') { 
			$next = $k;
			$seq .= $k;
		} else { 
			$todo[] = $k;
		}
	}

	var_dump($seq);
}
var_dump($next_step);*/




/*var_dump($next_step);
var_dump($dependant);
echo PHP_EOL;
var_dump(array_merge_recursive($next_step,$dependant));*/

