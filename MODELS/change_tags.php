<?php

include_once ("includes/identifiants.php");
include_once ('includes/securite.class.php');

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

$req = $bdd->prepare("UPDATE images SET tags=:tags WHERE nom_hash=:idhash AND id_user=:iduser");
if($req->execute([
	':tags' => Securite::bdd($_REQUEST['tags']),
	':idhash' => Securite::bdd($_REQUEST['id']),
	':iduser' => Securite::bdd($_SESSION['id'])
])) {
	header("Location:../view.php?id=$_REQUEST[id]");
} else {
	echo "Erreur";
}

