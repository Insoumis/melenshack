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
$titre = htmlspecialchars($_REQUEST['titre']);

if(strlen($titre) > 250) {
	echo "Titre trop grand";
	exit();
}

$req = $bdd->prepare("UPDATE images INNER JOIN users ON id_user=users.id SET titre=:titre WHERE nom_hash=:idhash AND (id_user=:iduser OR grade >= 5) ");
if($req->execute([
	':titre' => Securite::bdd($_REQUEST['titre']),
	':idhash' => Securite::bdd($_REQUEST['id']),
	':iduser' => Securite::bdd($_SESSION['id'])
])) {
	header("Location:../view.php?id=$_REQUEST[id]");
} else {
	echo "Erreur";
}

