<?php

require 'MODELS/cardsinfo.php';

$idhash = $_GET['id'];

//récupère les infos du post
$infosJson = getInfo($idhash);

$infos = json_decode($infosJson, true);

$id = $infos['id'];
$titre = $infos['titre'];
$idUser = $infos['idUser'];
$pseudoUser = $infos['pseudoUser'];
$urlSource = $infos['urlSource'];
$points = $infos['pointsTotaux'];

$width = getimagesize($urlSource)[0];
$height = getimagesize($urlSource)[1];

//date actuelle
$now = getdate();

//date de création du post
$then = date_parse($infos['dateCreation']);

//détermine le temps passé depuis la création du post
$temps= "";
if($now['year'] != $then['year']) {
	$temps = $now['year'] - $then['year'];
	if($temps == 1)	
		$temps = $temps . " an";
	else
		$temps = $temps . " années";	
	} else if($now['mon'] != $then['month']) {
		$temps = $now['mon'] - $then['month'];
		$temps = $temps . " mois";
	} else if($now['mday'] != $then['day']) {
		$temps = $now['mday'] - $then['day'];
		if($temps == 1)
			$temps = $temps . " jour";
		else
			$temps = $temps . " jours";
	} else if($now['hours'] != $then['hour']) {
		$temps = $now['hours'] - $then['hour'];
		if($temps == 1)
			$temps = $temps . " heure";
		else
			$temps = $temps . " heures";
	} else if($now['minutes'] != $then['minute']) {
		$temps = $now['minutes'] - $then['minute'];
		if($temps == 1)
			$temps = $temps . " minute";
		else
			$temps = $temps . " minutes";
	} else if($now['seconds'] != $then['second']) {
		$temps = $now['seconds'] - $then['second'];
		if($temps == 1)
			$temps = $temps . " seconde";
		else
			$temps = $temps . " secondes";
	} else
		$temps = "1 nanoseconde";

