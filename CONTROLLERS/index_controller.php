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

$evenement = false;
if($_REQUEST['tag'] == '18mars')
	$evenement = true;

$tag20mars = false;
if($_REQUEST['tag'] == '20mars')
	$tag20mars=true;

$tagRennes = false;
if($_REQUEST['tag'] == 'rennes')
	$tagRennes=true;

$tagMelenphone = false;
if($_REQUEST['tag'] == 'melenphone')
	$tagMelenphone = true;

$tagCulture = false;
if($_REQUEST['tag'] == 'culture_insoumise')
	$tagCulture = true;


$tagLegislatives = false;
if($_REQUEST['tag'] == 'visuel_legislatives')
	$tagLegislatives = true;
