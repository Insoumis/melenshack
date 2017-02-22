<?php
$grade = 0;
require 'MODELS/check_grade.php';


if(!isset($_SESSION))
	session_start();

$connexionButton = true;
$id_user = "";

if(isset($_SESSION['id']) && isset($_SESSION['pseudo'])) {
	$connexionButton = false;
	$id_user = $_SESSION['id'];
}

$sort = "hot";
if(isset($_GET['sort']))
	$sort = $_GET['sort'];


$baseName= basename($_SERVER['PHP_SELF']);

$isHotActive = false;
$isNewActive = false;
$isRandomActive = false;

$showSearch = false;
if($baseName == "index.php")
	$showSearch = true;

if($baseName == "index.php" && $sort == "new")
	$isNewActive = true;
else if($baseName == "index.php" && $sort == "random")
	$isRandomActive = true;
else if($baseName == "index.php" && $sort == "hot")
	$isHotActive = true;

