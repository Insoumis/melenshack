<?php

include("includes/identifiants.php");
include_once ('includes/token.class.php');
date_default_timezone_set('Europe/Paris');

if (!isset($_SESSION)) {
	session_start ();
}
if (!$_SESSION) {
	header('Location:../pseudo.php?erreur=notlogged');
	exit();
};

$id_user = $_SESSION['id'];
if (!$id_user) {
	header("HTTP/1.0 403 Forbidden");
	exit();
}

$pseudo = htmlspecialchars($_POST['pseudo']);

if(!isset($_SESSION['id'])) {
	header('Location:../pseudo.php?erreur=notlogged');
	exit();
}

if((Token::verifier(600, 'A')) == false) {
	header('Location:../pseudo.php?erreur=token');
	exit();
}

$req = $bdd->prepare("SELECT * FROM users WHERE pseudo=:pseudo");
$req->execute([
	':pseudo' => htmlspecialchars($pseudo),
]);

$res = $req->fetch();

if($res) {
	header("Location:../pseudo.php?erreur=taken");
	exit();
}


$req2 = $bdd->prepare ('SELECT * FROM users WHERE id = :pseudo');
$req2->execute ([
	':pseudo' => htmlspecialchars($id_user),
]);
$resultat2 = $req2->fetch ();

$datebdd = $resultat2['datepseudochange'];

if ($datebdd != 'null') {

	$date = date("Y-m-d H:i:s", strtotime('+1 hours', strtotime($datebdd)));
	$today = date("Y-m-d H:i:s");
	if ($today < $date) {
		header("Location:../pseudo.php?erreur=date");
		exit();
	}
}

$req = $bdd->prepare("UPDATE users SET pseudo=:pseudo, datepseudochange = NOW() WHERE id=:id");
$req->execute([
	':pseudo' => htmlspecialchars($pseudo),
	':id' => $_SESSION['id'],
]);

$_SESSION['pseudo'] = htmlspecialchars($pseudo);
header('Location: ../index.php');
