#!/usr/bin/php
<?php
ini_set('memory_limit','-1');

$input = file("input.txt",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$grid = array();
$id_overlaps = array();
$overlap = 0;

foreach ($input as $line) {

	preg_match("/#([0-9]+) @ ([0-9]+),([0-9]+): ([0-9]+)x([0-9]+)/",$line,$matches);
	list(, $id, $left, $top, $width, $height) = $matches;
	$id_overlaps[$id] = false;

	
	for ($x = $left; $x < ($left + $width); $x++) {
		for ($y = $top; $y < ($top + $height); $y++) {
			$coord = [$x,$y];

			$gid = cantor($coord[0], $coord[1]);
			$grid[$gid][] = $id;
			$count = count($grid[$gid]);
			if ($count == 2) {
				$overlap++;
			}
			if ($count >= 2) {
				foreach ($grid[$gid] as $update) {
					unset($id_overlaps[$update]);
				}
			}
		}
	}
}
echo $overlap;
echo PHP_EOL;
echo array_keys($id_overlaps)[0];
echo PHP_EOL;


function cantor($x, $y) {
	return (($x + $y) * ($x + $y + 1)) / 2 + $y;

}
