<?php

include 'MODELS/includes/constants.php';

$maxsize = MAX_SIZE;

$errmsg = "";
$showPage = true;
if(isset($_GET['erreur']) && !empty($_GET['erreur'])) {
	
	$erreur = $_GET['erreur'];
		if ($erreur == "notlogged")
			$errmsg = "Vous devez être connecté pour poster une image ! <a href='login.php'>Se connecter.</a>";
		else if ($erreur == "captcha")
			$errmsg = "Captcha invalide ! Veuillez réessayer.";
		else if ($erreur == "size")
			$errmsg = "Image trop lourde !";
		else if ($erreur == "format")
			$errmsg = "L'image doit être en format PNG, JPG, JPEG ou GIF !";
		else if ($erreur == "titre")
			$errmsg = "Titre trop long !";
		else
			$errmsg = "Veuillez réessayer";

} else if (!isset($_SESSION['id'])) {
	$errmsg = "Vous devez être connecté pour pouvoir poster une image ! <a href='login.php'>Se connecter</a>.";
	$showPage = false;
}

