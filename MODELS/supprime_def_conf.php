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

$req = $bdd->prepare ('SELECT * FROM images WHERE nom_hash = :idhash ');
$req->execute ([
    ':idhash' => htmlspecialchars($_POST['idhash']),
]);
$resultat = $req->fetch ();

if (!$resultat) {
	header('HTTP/1.0 400 Bad Request');
    exit();
}

$req2 = $bdd->prepare ('SELECT grade FROM users WHERE id = :id_user ');
$req2->execute ([
    ':id_user' => $id_user,
]);
$resultat2 = $req2->fetch ()['grade'];

if ($resultat2 < 1) {
    //pas assez gradé 
	header('HTTP/1.0 403 Forbidden');
    exit();
}
// Supprimer image + vignette si pas URL
$id = $resultat["nom_hash"];
$extension_image = $resultat["format"];

unlink(__DIR__ .'/../vignettes/'. $id .'.'.$extension_image);
if (empty($resultat["url"])) {
    unlink(__DIR__ .'/../images/'. $id .'.'.$extension_image);
}

$req = $bdd->prepare ('DELETE FROM images WHERE nom_hash = :idhash');
$req->execute ([
	':idhash' => $_POST['idhash'],
]);
