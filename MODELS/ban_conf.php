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

if(!Token::verifier(600, 'A') && !Token::verifier(600, 'admin')) {
    header('HTTP/1.0 403 Forbidden');
    echo 'Erreur Token';
    exit();
}

if(!isset($_POST['value']) || ($_POST['value'] != 0 && $_POST['value'] != 1)) {
	echo $_POST['value'];
	exit();
}
$value = $_POST['value'];


if(!empty($_POST['id_user']))
	$idban = Securite::bdd($_POST['id_user']);
else
	$idban = '';

if(!empty($_POST['pseudo']))
	$pseudo = Securite::bdd($_POST['pseudo']);
else
	$pseudo = '';

$req = $bdd->prepare ("SELECT * FROM users WHERE (:idban = '' AND pseudo = :pseudo) OR id=:idban");
$req->execute ([
    ':pseudo' => $pseudo,
    ':idban' => $idban,
]);
$resultat = $req->fetch ();

if (!$resultat) {

    echo "User introuvable";
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

if($value == 1) {
	
	$req = $bdd->prepare ("SELECT * FROM ban WHERE id_user = :idban");
	$req->execute ([
	    ':idban' => $idban,
	]);
	$resultat = $req->fetch ();

	if($resultat) {
		exit();
	}

	$req = $bdd->prepare ('INSERT INTO ban(id_user) VALUES(:id_user)');
	$req->execute ([
	    ':id_user' => $idban,
	]);

} else {
	$req = $bdd->prepare ('DELETE FROM ban WHERE id_user = :id_user');
	$req->execute ([
	    ':id_user' => $idban,
	]);

}
header('Location:../admin.php');
