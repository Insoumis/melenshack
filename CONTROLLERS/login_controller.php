<?php

require_once ('MODELS/includes/token.class.php');

$token = Token::generer('connexion');
$errmsg = "";
$showPage = true;
if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])) {
	$errmsg = "<strong>Vous êtes déjà connecté !</strong> Voulez vous <a href='MODELS/disconnect_conf.php'>vous déconnecter</a> ?";
	$showPage = false;
}  else if (isset($_GET['erreur']) && !empty($_GET['erreur'])) {
	$erreur = $_GET['erreur'];
	if ($erreur == "wrong")
		$errmsg = "Nom d'utilisateur ou mot de passe invalide !";
	else if ($erreur == "token")
		$errmsg = "Token invalide ! Veuillez réessayer";
	else if ($erreur == "banned")
		$errmsg = "Vous avez été banni !";
	else
		$errmsg = "Veuillez réessayer !";
}



