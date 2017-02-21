<?php


if(!isset($_SESSION))
	session_start();

$connexionButton = true;

if(isset($_SESSION['id']) && isset($_SESSION['pseudo']))
	$connexionButton = false;

$sort = "hot";
if(isset($_GET['sort']))
	$sort = $_GET['sort'];


$baseName= basename($_SERVER['PHP_SELF']);

$isHotActive = false;
$isNewActive = false;
$isRandomActive = false;


if($baseName == "index.php" && $sort == "new")
	$isNewActive = true;
else if($baseName == "index.php" && $sort == "random")
	$isRandomActive = true;
else if($baseName == "index.php" && $sort == "hot")
	$isHotActive = true;

?>

