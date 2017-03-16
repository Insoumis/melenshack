<?php

include_once ("includes/identifiants.php");
include_once ('includes/securite.class.php');
include_once 'check_grade.php';

if(empty($_SESSION))
	session_start();

if(empty($_SESSION['id'])) {
	echo "non connecté";
	exit();
}

if(empty($_REQUEST['id'])) {
	echo "mauvaise image";
	exit();
}
/*
$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domaine= parse_url(SITE_DOMAINE, PHP_URL_HOST);
if ($referer != $domaine) {
	header("HTTP/1.0 403 Forbidden");
	exit();
} */

if(count(explode(",", $_REQUEST['tags'])) > 10) {
	echo "trop de tags";
	exit();
}

$req = $bdd->prepare("SELECT id_user FROM images WHERE nom_hash=:idhash ");
$req->execute([
	':idhash' => Securite::bdd($_REQUEST['id']),
]);
$idPosteur = $req->fetch()['id_user'];

if($grade < 5  && $idPosteur != $_SESSION['id']) {
	echo "Pas la permission";
	exit();
}

$req = $bdd->prepare("UPDATE images SET tags=:tags WHERE nom_hash=:idhash");
if($req->execute([
	':tags' => Securite::bdd($_REQUEST['tags']),
	':idhash' => Securite::bdd($_REQUEST['id']),
])) {
	echo "Success";
} else {
	echo "Erreur";
}

