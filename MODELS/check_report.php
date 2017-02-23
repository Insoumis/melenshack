<?php
include ("includes/identifiants.php");
include_once ('includes/token.class.php');
include_once ("includes/constants.php");


if (!isset($_SESSION)) {
    session_start ();
}
if (!$_SESSION) {
    exit();
};
$id_user = $_SESSION['id'];
if (!$id_user) {
    echo 0;
	exit();
};

$req = $bdd->prepare ('SELECT id FROM images WHERE nom_hash = :idhash');
$req->execute ([
    ':idhash' => $_POST['idhash'],
]);
$resultat = $req->fetch ();

if (!$resultat) {
    //$_POST['id_image'] ne correpond pas à une image valide
	echo 0;
    exit();
}

$id = $resultat['id'];

$req = $bdd->prepare ('SELECT * FROM report WHERE id_image = :id_image AND id_user = :id_user');
$req->execute ([
    ':id_image' => $id,
    ':id_user' => $id_user,
]);

$resultat = $req->fetch ();

if (!$resultat OR $resultat == null) // Si User n'a pas encore voté sur cette image
{
	echo 0;
	exit();
} else { // Si user a déja voté sur cette image
	echo 1;
	exit();
}
