<?php
/*
	Fichier à include, qui initialise la var $grade

*/

include ("includes/identifiants.php");
include_once ('includes/token.class.php');
include_once ("includes/constants.php");
include_once ('includes/securite.class.php');

if (!isset($_SESSION)) {
    session_start ();
}
if (!$_SESSION) {
    return;
}
if (empty($_SESSION['id'])) {
    // User non connecté
    return;
}

$req = $bdd->prepare ('SELECT grade FROM users WHERE id = :id_user ');
$req->execute ([
    ':id_user' => Securite::bdd($_SESSION['id']),
]);
$grade = $req->fetch ()['grade'];

if(!$grade)
	$grade = 0;
