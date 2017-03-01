<?php

include("includes/identifiants.php");

if(!$_SESSION)
	session_start();

$pseudo = $_POST['pseudo'];

if(!isset($_SESSION['id'])) {
	header('Location:../pseudo.php?erreur=notlogged');
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

$req = $bdd->prepare("UPDATE users SET pseudo=:pseudo WHERE id=:id");
$req->execute([
	':pseudo' => htmlspecialchars($pseudo),
	':id' => $_SESSION['id'],
]);

$_SESSION['pseudo'] = htmlspecialchars($pseudo);
header('Location: ../index.php');
