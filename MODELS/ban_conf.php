<?php
include ("includes/identifiants.php");
include_once ('includes/token.class.php');
include_once ("includes/constants.php");
include_once ('includes/securite.class.php');

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
$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domaine= parse_url(SITE_DOMAINE, PHP_URL_HOST);
if ($referer != $domaine) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}

if((Token::verifier(600, 'A')) == false) {
    header('HTTP/1.0 403 Forbidden');
    echo 'Erreur Token';
    exit();
}

if(!empty($_POST['id_user']))
	$idban = Securite::bdd($_POST['id_user']);
else
	$idban = '';


$req = $bdd->prepare ("SELECT * FROM users WHERE (:idban = '' AND pseudo = :pseudo) OR id=:idban");
$req->execute ([
    ':pseudo' => Securite::bdd($_POST['pseudo']),
    ':idban' => $idban,
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
    header('HTTP/1.0 403 Forbidden');
    echo 'Erreur pseudo';
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
