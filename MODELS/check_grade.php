<?php
/*
	Fichier à include, qui initialise la var $grade

*/

include ("includes/identifiants.php");
include_once ('includes/token.class.php');
include_once ("includes/constants.php");

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
    ':id_user' => $_SESSION['id'],
]);
$grade = $req->fetch ()['grade'];

if(empty($grade))
		$grade = 0;
