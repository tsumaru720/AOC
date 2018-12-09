#!/usr/bin/php
<?php

/*
Specifically, a node consists of:

A header, which is always exactly two numbers:
The quantity of child nodes.
The quantity of metadata entries.
Zero or more child nodes (as specified in the header).
One or more metadata entries (as specified in the header).

Each child node is itself a node that has its own header, child nodes, and metadata. For example:

2 3 0 3 10 11 12 1 1 0 1 99 2 1 1 2
A----------------------------------
    B----------- C-----------
                     D-----
In this example, each node of the tree is also marked with an underline starting with a letter for easier identification. In it, there are four nodes:

A, which has 2 child nodes (B, C) and 3 metadata entries (1, 1, 2).
B, which has 0 child nodes and 3 metadata entries (10, 11, 12).
C, which has 1 child node (D) and 1 metadata entry (2).
D, which has 0 child nodes and 1 metadata entry (99).

*/


$input = file('input.txt',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)[0];
$tree = explode(' ', $input);
$nodes = [];
$meta_count = 0;

$tree = array_reverse($tree);

add_node($tree);
echo $meta_count;
echo PHP_EOL;


function add_node(&$data) {
	global $nodes, $meta_count;

	$meta = [];

	$header['children'] = array_pop($data);
	$header['metadata'] = array_pop($data);
	
	for ($i = 0; $i < $header['children']; $i++) {
		add_node($data);
	}

	for ($i = 0; $i < $header['metadata']; $i++) {
		$meta[] = array_pop($data);
	}
	$nodes[] = ['header' => ['children' => $header['children'], 'metadata' => $header['metadata']], 'metadata' => $meta];
	$meta_count += array_sum($meta);
}



