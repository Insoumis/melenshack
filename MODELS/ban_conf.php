<?php
include ("includes/identifiants.php");
include_once ('includes/token.class.php');
include_once ("includes/constants.php");

if (!isset($_SESSION)) {
    session_start ();
}
if (!$_SESSION) {
    header("HTTP/1.0 403 Forbidden");
	exit();
};
$id_user = $_SESSION['id'];
if (!$id_user) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}



$req = $bdd->prepare ('SELECT * FROM users WHERE pseudo = :pseudo ');
$req->execute ([
    ':pseudo' => $_POST['pseudo'],
]);
$resultat = $req->fetch ();

if (!$resultat) {
    exit();
}
$idban = $resultat['id'];
$gradeban = $resultat['grade'];


$req = $bdd->prepare ('SELECT * FROM users WHERE id = :id ');
$req->execute ([
    ':id' => $id_user,
]);
$resultat = $req->fetch ();

if (!$resultat) {
    exit();
}
$grade = $resultat['grade'];

if ($grade <= $gradeban) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}


$req = $bdd->prepare ('INSERT INTO ban(id_user) VALUES(:id_user)');
$req->execute ([
    ':id_user' => $idban,
]);

header('Location:../admin.php');
