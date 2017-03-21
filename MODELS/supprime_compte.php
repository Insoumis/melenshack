<?php
include ("includes/identifiants.php");
include_once ('includes/token.class.php');
include_once ("includes/constants.php");

if (!isset($_SESSION)) {
    session_start ();
}
if (!$_SESSION) {
	header('HTTP/1.0 403 Forbidden');
    exit();
};
/*
$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domaine= parse_url(SITE_DOMAINE, PHP_URL_HOST);
if ($referer != $domaine) {
	header("HTTP/1.0 403 Forbidden");
	exit();
} */

$id_user = $_SESSION['id'];
if (!$id_user) {
	header('HTTP/1.0 403 Forbidden');
    exit();
};

if((Token::verifier(600, 'A')) == false) {
	header('HTTP/1.0 403 Forbidden');
	echo 'Erreur Token';
	exit();
}

$req = $bdd->prepare ('DELETE FROM federated_users WHERE id_user = :id');
$req->execute ([
	':id' => $id_user,
]);

$req = $bdd->prepare ('DELETE FROM classic_users WHERE id_user = :id');
$req->execute ([
	':id' => $id_user,
]);

$req = $bdd->prepare ('DELETE FROM images WHERE id_user = :id');
$req->execute ([
	':id' => $id_user,
]);

$req = $bdd->prepare ('DELETE FROM users WHERE id = :id');
$req->execute ([
	':id' => $id_user,
]);

$req = $bdd->prepare ('UPDATE users SET gradeupdatedby=NULL WHERE gradeupdatedby = :id');
$req->execute ([
	':id' => $id_user,
]);

header('Location:disconnect_conf.php');
