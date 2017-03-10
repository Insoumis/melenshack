<?php
/*
	METHOD: POST

	:pseudo = id de l'user à promote
	:value = grade à attribuer

*/


include_once ("includes/identifiants.php");
include_once ('includes/token.class.php');
include_once ("includes/constants.php");
include_once ('includes/securite.class.php');

if (!isset($_SESSION)) {
    session_start ();
}
if (!$_SESSION) {
	header('HTTP/1.0 403 Forbidden');
    exit();
};
$id_user = Securite::bdd($_SESSION['id']);
if (!$id_user) {
	header('HTTP/1.0 403 Forbidden');
    exit();
};

if(!isset($_POST['value'])) {
	header('HTTP/1.0 403 Forbidden');
	exit();
}

if(!Token::verifier(600, 'A') && !Token::verifier(600, 'admin')) {
	header('HTTP/1.0 403 Forbidden');
	exit();
}

$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domaine= parse_url(SITE_DOMAINE, PHP_URL_HOST);
if ($referer != $domaine) {
	header("HTTP/1.0 403 Forbidden");
	exit();
}

$val = Securite::bdd(intval($_POST['value']));

$req = $bdd->prepare ('SELECT id FROM users WHERE pseudo = :pseudo ');
$req->execute ([
    ':pseudo' => Securite::bdd($_POST['pseudo']),
]);
$resultat = $req->fetch ();

if (!$resultat) {
	header('HTTP/1.0 403 Forbidden');
	echo "Utilisateur inexistant";
    exit();
}

$req = $bdd->prepare ('SELECT grade FROM users WHERE id = :id_user ');
$req->execute ([
    ':id_user' => $id_user,
]);
$resultat = $req->fetch ()['grade'];

if ($resultat < $val) {
    //pas assez gradé
	header('HTTP/1.0 403 Forbidden');
	echo "Vous n'etes pas assez gradé";
    exit();
}

if ("42" < $val) {
	//Really Nigga ? <3
	header('Location:../admin.php?erreur=toohigh');
	exit();
}


$req = $bdd->prepare ('UPDATE users SET grade = :val, gradeupdatedby = :gradeupdatedby WHERE pseudo = :pseudo');
$req->execute ([
	':pseudo' => $_POST['pseudo'],
	':val' => $val,
	':gradeupdatedby' => $id_user,
]);


header('Location:../admin.php');
