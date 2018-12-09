#!/usr/bin/php
<?php

$input = file('input.txt',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)[0];
$tree = explode(' ', $input);
$nodes = [];
$metadata_total = 0;
$current_node = 0;

$tree = array_reverse($tree);

// Part 1
add_node($tree);
echo $metadata_total;
echo PHP_EOL;

// Part 2
$root_value = 0;
get_value(0);
echo $root_value;
echo PHP_EOL;

// End

function get_value($check) {
	global $root_value, $nodes;
	$i = $check;

	if (!array_key_exists('children',$nodes[$i])) {
		$root_value += $nodes[$i]['value'];
	} else {
		foreach ($nodes[$i]['metadata'] as $metadata) {
			if ($metadata <= count($nodes[$i]['children'])) {
				get_value($nodes[$i]['children'][$metadata - 1]);
			}
		}
	}
}

function add_node(&$data, $parent = -1) {
	global $nodes, $metadata_total, $current_node;

	$metadata = [];
	$index = $current_node;
	$current_node++;

	$children_count = array_pop($data);
	$metadata_count = array_pop($data);

	for ($i = 0; $i < $children_count; $i++) {
		add_node($data, $index);
	}

	for ($i = 0; $i < $metadata_count; $i++) {
		$metadata[] = array_pop($data);
	}

	$nodes[$index]['metadata'] = $metadata;
	$nodes[$index]['value'] = array_sum($metadata);

	if ($parent >= 0) {
		$nodes[$parent]['children'][] = $index;
	}

	$metadata_total += $nodes[$index]['value'];

}



