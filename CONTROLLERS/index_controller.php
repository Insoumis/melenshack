<?php

$showSupprime = false;
if(isset($grade) && $grade > 0)
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
