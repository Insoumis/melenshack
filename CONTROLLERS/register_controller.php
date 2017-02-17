<?php
	
require_once 'MODELS/includes/token.class.php';
$token = Token::generer('inscription');

$googleKey = "6LefaBUUAAAAALVKIo2DiW_hWLs2kijFTrlUHGMb";

$errmsg = "";
$showPage = true;
if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])) {
	
		$errmsg = "<strong>Vous êtes déjà connecté !</strong> Voulez vous <a href='disconnect.php'>vous déconnecter</a> ?";
		$showPage = false;

} else if(isset($_GET['erreur']) && !empty($_GET['erreur'])) {
	$erreur = $_GET['erreur'];
	if ($erreur == "doublon")
		$errmsg = "Adresse mail ou nom d'utilisateur déjà utilisé !";
	else if ($erreur == "captcha")
		$errmsg = "Captcha invalide ! Veuillez réessayer.";
	else if ($erreur == "pass")
		$errmsg = "Confirmation du mot de passe invalide !";
	else if ($erreur == "email")
		$errmsg = "Adresse mail invalide !";
	else if ($erreur == "login")
		$errmsg = "Login ou mot de passe invalide !";
	else if ($erreur == "token")
		$errmsg = "Token invalide !";
	else
		$errmsg = "Veuillez réessayer";
}

