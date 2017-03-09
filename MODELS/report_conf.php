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
$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domaine= parse_url(SITE_DOMAINE, PHP_URL_HOST);
if ($referer != $domaine) {
    exit();
}

$id_user = $_SESSION['id'];
if (!$id_user) {
    // User non connecté
    exit();
};

$req = $bdd->prepare ('SELECT id FROM images WHERE nom_hash = :idhash ');
$req->execute ([
    ':idhash' => $_POST['idhash'],
]);
$resultat = $req->fetch ();

if (!$resultat) {
    exit();
}
$id = $resultat['id'];

$req = $bdd->prepare ('SELECT * FROM report WHERE id_image = :id_image AND id_user = :id_user');
$req->execute ([
    ':id_image' => $id,
    ':id_user' => $id_user,
]);

$resultat = $req->fetch ();

if(!$resultat OR $resultat == null) {

    $req = $bdd->prepare ('INSERT INTO report(id_user, id_image) VALUES(:id_user, :id_image)');
    $req->execute ([
        ':id_user' => $id_user,
        ':id_image' => $id,
    ]);
}
