<?php

require 'MODELS/cardsinfo.php';

$showSupprime = false;
if(isset($grade) && $grade > 0)
	$showSupprime = true;
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
	$points = $infos['pointsTotaux'];
	$tagsstr = $infos['tags'];
	$tags = explode(",", $infos['tags']);
	$dateCreation = $infos['dateCreation'];
	$vote = $infos['ancien_vote'];
	$report = $infos['ancien_report'];
	$supprime = $infos['supprime'];

	$inscription = $infos['inscription'];
	$pointsUser = $infos['pointsUser'];
	$posts = $infos['posts'];
	$idUser = $infos['idUser'];

	$width = getimagesize($urlSource)[0];
	$height = getimagesize($urlSource)[1];

	$showPage = true;
	if($supprime && $grade == 0)
		$showPage = false;

}
