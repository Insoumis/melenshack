<?php

$showSupprime = false;
if(isset($grade) && $grade > 0)
	$showSupprime = true;

//url params
$search_id_user = "";
if(isset($_REQUEST['id_user'])) {
	$search_id_user = $_REQUEST['id_user'];
}

$search_tags = "";
if(isset($_REQUEST['tag'])) {
	$search_tags = $_REQUEST['tag'];
}
