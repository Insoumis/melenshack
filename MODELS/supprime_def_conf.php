<?php
/*
	METHOD: POST

	:idhash = id hashé de l'image à supprimer

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

$req = $bdd->prepare ('SELECT id_user FROM images WHERE nom_hash = :idhash ');
$req->execute ([
    ':idhash' => $_POST['idhash'],
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

if ($resultat < 1) {
    //pas assez gradé 
	header('HTTP/1.0 403 Forbidden');
    exit();
}
// Supprimer image + vignette si pas URL
$req = $bdd->prepare ('DELETE FROM images WHERE nom_hash = :idhash');
$req->execute ([
	':idhash' => $_POST['idhash'],
]);
