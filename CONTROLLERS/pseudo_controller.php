<?php

$fromregister = false;
$pseudo = "";

if(isset($_GET['erreur']) && !empty($_GET['erreur'])) {
	if ($_GET['erreur'] == 'fromregister') {
		$fromregister = true;
		if (!empty($_GET['pseudo'])) {
			$pseudo = rawurldecode ($_GET['pseudo']);
		}
	} else if ($_GET['erreur'] == "taken") {
		$errmsg = "Ce pseudo est déjà pris !";
	} else if ($_GET['erreur'] == "notlogged") {
		$errmsg = "Vous devez être connecté pour changer de pseudo. <a href='login.php'>Se connecter</a>";
	} else if ($_GET['erreur'] == "date") {
		$errmsg = "Afin d'éviter les abus, vous ne pouvez changer votre pseudo qu'une fois par heure. Veuillez réessayer plus tard.";
	} else if ($_GET['erreur'] == "token") {
		$errmsg = "Mauvais token. Veuillez réessayer.";
}
	
}

$showPage = true;
if(!isset($_SESSION['id'])) {
	$showPage = false;
	$errmsg = "Vous devez être connecté pour changer de pseudo. <a href='login.php'>Se connecter</a>";
}
