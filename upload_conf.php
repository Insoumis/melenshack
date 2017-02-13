<?php

$max_size = 1000000;
$img = $_FILES['file'];
if($img['size'] > $max_size)
	exit();
echo $img['name'];

?>
