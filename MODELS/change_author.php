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
if($grade < 5) {
	echo "Pas assez gradé";
	exit();
}

$mode_maintenance = false;
if ($mode_maintenance == true) {
	echo "Interdit de modifier pendant le période electorale !";
	exit();
}
/*
$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domaine= parse_url(SITE_DOMAINE, PHP_URL_HOST);
if ($referer != $domaine) {
	header("HTTP/1.0 403 Forbidden");
	exit();
} */
$pseudo = htmlspecialchars($_REQUEST['pseudo']);

if(strlen($pseudo) > 250) {
	echo "Pseudo trop grand";
	exit();
}

$req = $bdd->prepare("UPDATE images SET pseudo_author=:pseudo WHERE nom_hash=:idhash");
if($req->execute([
	':pseudo' => Securite::bdd($pseudo),
	':idhash' => Securite::bdd($_REQUEST['id']),
])) {
	header("Location:../view.php?id=$_REQUEST[id]");
} else {
	echo "Erreur";
}

