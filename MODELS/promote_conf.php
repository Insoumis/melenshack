<?php
/*
	METHOD: POST

	:pseudo = id de l'user à promote
	:value = grade à attribuer

*/


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
$id_user = $_SESSION['id'];
if (!$id_user) {
	header('HTTP/1.0 403 Forbidden');
    exit();
};

if(!isset($_POST['value'])) {
	header('HTTP/1.0 400 Bad Request');
	exit();
}

$val = $_POST['value'];

$req = $bdd->prepare ('SELECT id FROM users WHERE pseudo = :pseudo ');
$req->execute ([
    ':pseudo' => $_POST['pseudo'],
]);
$resultat = $req->fetch ();

if (!$resultat) {
	header('HTTP/1.0 400 Bad Request');
    exit();
}

$req = $bdd->prepare ('SELECT grade FROM users WHERE id = :id_user ');
$req->execute ([
    ':id_user' => $id_user,
]);
$resultat = $req->fetch ()['grade'];

if ($resultat < $val) {
    //pas assez gradé
	header('HTTP/1.0 403 Forbidden');
    exit();
}



$req = $bdd->prepare ('UPDATE users SET grade = :val WHERE pseudo = :pseudo');
$req->execute ([
	':pseudo' => $_POST['pseudo'],
	':val' => $val
]);


header('Location:../admin.php');
