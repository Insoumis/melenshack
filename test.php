<?php

function encode($str) {
//longueur str max: ~15

	$str = base_convert($str, 16, 8);

	$keys = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
	$index = 0;
	$res = '';
	do {
		$i1 = $str[$index];
		$i2 = $str[$index+1];
		$res .= $keys[intval($i2)+8*intval($i1)];

		$index += 2;
	} while($index < strlen($str));
	return $res;
}
$num = 2;
$hash = substr(md5($num), 0, 12);
echo "<br>";
echo encode($hash);
