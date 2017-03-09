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
	}
}

$showPage = true;
if(!isset($_SESSION['id'])) {
	$showPage = false;
	$errmsg = "Vous devez être connecté pour changer de pseudo. <a href='login.php'>Se connecter</a>";
}
