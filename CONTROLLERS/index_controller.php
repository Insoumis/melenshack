<?php

$showSupprime = false;
if(isset($grade) && $grade >= 5)
	$showSupprime = true;

//url params
$search_pseudo = "";
if(isset($_REQUEST['pseudo'])) {
	$search_pseudo = $_REQUEST['pseudo'];
}

$search_tags = "";
if(isset($_REQUEST['tag'])) {
	$search_tags = $_REQUEST['tag'];
}

$showPage = true;
if($grade < 5 && ($_REQUEST['sort'] == "deleted" || $_REQUEST['sort'] == "report"))
	$showPage = false;

$concours = false;
if($_REQUEST['tag'] == 'concours')
	$concours = true;
