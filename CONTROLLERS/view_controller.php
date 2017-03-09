<?php

require 'MODELS/cardsinfo.php';

$idhash = $_GET['id'];

//récupère les infos du post
$infosJson = getInfo($idhash);

$infos = json_decode($infosJson, true);


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
//$format = $infos['dateCreation'];

$width = getimagesize($urlSource)[0];
$height = getimagesize($urlSource)[1];
