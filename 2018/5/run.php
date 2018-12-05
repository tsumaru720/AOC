#!/usr/bin/php
<?php

$pairs = array('aA' => '','Aa' => '','bB' => '','Bb' => '','cC' => '','Cc' => '','dD' => '','Dd' => '',
		'eE' => '','Ee' => '','fF' => '','Ff' => '','gG' => '','Gg' => '','hH' => '','Hh' => '',
		'iI' => '','Ii' => '','jJ' => '','Jj' => '','kK' => '','Kk' => '','lL' => '','Ll' => '',
		'mM' => '','Mm' => '','nN' => '','Nn' => '','oO' => '','Oo' => '','pP' => '','Pp' => '',
		'qQ' => '','Qq' => '','rR' => '','Rr' => '','sS' => '','Ss' => '','tT' => '','Tt' => '',
		'uU' => '','Uu' => '','vV' => '','Vv' => '','wW' => '','Ww' => '','xX' => '','Xx' => '',
		'yY' => '','Yy' => '','zZ' => '','Zz' => '');


$polymer = file("input.txt",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)[0];
$tmp = strtr($polymer,$pairs);

while ($tmp !== $polymer) {
	$polymer = $tmp;
	$tmp = strtr($polymer,$pairs);
}

echo strlen($polymer);
echo PHP_EOL;
