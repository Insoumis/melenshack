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
    ':idhash' => htmlspecialchars($_POST['idhash']),
]);
$resultat = $req->fetch ();

if (!$resultat) {
    exit();
}
$id = $resultat['id'];

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

$req = $bdd->prepare ('SELECT * FROM report WHERE id_image = :id_image');
$req->execute ([
    ':id_image' => $id,
]);

$resultat = $req->fetch ();

if(!$resultat OR $resultat == null) {
    exit(); // Le post n'est pas dans la table report
} else {
    $req = $bdd->prepare ('DELETE FROM report WHERE id_image = :id_image');
    $req->execute ([
        ':id_image' => $id,
    ]);
}
