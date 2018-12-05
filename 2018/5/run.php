#!/usr/bin/php
<?php

$alphabet = [
	['a','A'], ['b','B'], ['c','C'], ['d','D'], ['e','E'], ['f','F'], ['g','G'], ['h','H'], ['i','I'],
	['j','J'], ['k','K'], ['l','L'], ['m','M'], ['n','N'], ['o','O'], ['p','P'], ['q','Q'], ['r','R'],
	['s','S'], ['t','T'], ['u','U'], ['v','V'], ['w','W'], ['x','X'], ['y','Y'], ['z','Z']
	];

$pairs = ['aA' => '','Aa' => '','bB' => '','Bb' => '','cC' => '','Cc' => '','dD' => '','Dd' => '','eE' => '',
		'Ee' => '','fF' => '','Ff' => '','gG' => '','Gg' => '','hH' => '','Hh' => '','iI' => '','Ii' => '',
		'jJ' => '','Jj' => '','kK' => '','Kk' => '','lL' => '','Ll' => '','mM' => '','Mm' => '','nN' => '',
		'Nn' => '','oO' => '','Oo' => '','pP' => '','Pp' => '','qQ' => '','Qq' => '','rR' => '','Rr' => '',
		'sS' => '','Ss' => '','tT' => '','Tt' => '','uU' => '','Uu' => '','vV' => '','Vv' => '','wW' => '',
		'Ww' => '','xX' => '','Xx' => '','yY' => '','Yy' => '','zZ' => '','Zz' => ''];


$polymer = file('input.txt',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)[0];
$polymer = react($polymer);

echo strlen($polymer);
echo PHP_EOL;

$result = array();

foreach ($alphabet as $pair) {
	$tmp = $polymer;
	$tmp = str_replace($pair, '', $tmp);

	$result[] = strlen(react($tmp));;
}

echo min($result);
echo PHP_EOL;

function react($polymer) {
	global $pairs;
	$tmp = strtr($polymer,$pairs);

	while ($tmp !== $polymer) {
		$polymer = $tmp;
		$tmp = strtr($polymer,$pairs);
	}

	return $tmp;
}
