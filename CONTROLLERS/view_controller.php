<?php

require 'MODELS/cardsinfo.php';

$showBan = false;
if(isset($grade) && $grade >= 5)
	$showBan = true;
	$idhash = $_GET['id'];

	//récupère les infos du post
	$infosJson = getInfo($idhash);

	$infos = json_decode($infosJson, true);

$showPage = true;
if($infos == -1)
	$showPage = false;
else {
	$id = $infos['id'];
	$idhash = $infos['idhash'];
	$titre = $infos['titre'];
	$idUser = $infos['idUser'];
	$pseudoUser = $infos['pseudoUser'];
	$urlSource = $infos['urlSource'];
	$urlThumbnail = $infos['urlThumbnail'];
	$points = $infos['pointsTotaux'];
	$tagsstr = $infos['tags'];
	$tags = explode(",", $infos['tags']);
	$dateCreation = $infos['dateCreation'];
	$vote = $infos['ancien_vote'];
	$report = $infos['ancien_report'];
	$supprime = $infos['supprime'];
	$type = $infos["type"];

	$inscription = $infos['inscription'];
	$pointsUser = $infos['pointsUser'];
	$posts = $infos['posts'];
	$idUser = $infos['idUser'];

	$width = getimagesize($urlSource)[0];
	$height = getimagesize($urlSource)[1];

	if($supprime && $grade < 5)
		$showPage = false;

	$showSupprime = false;
	if($grade >= 5 || $idUser == $_SESSION['id'])
		$showSupprime = true;

}
