<?php
include_once("MODELS/includes/identifiants.php");
include_once("MODELS/includes/constants.php");
require_once ('MODELS/includes/token.class.php');
include_once 'MODELS/check_grade.php';

$token_A = Token::generer('admin');
$errmsg = "";

if (!isset($_SESSION)) {
    session_start ();
}
if (!$_SESSION) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}
if (!isset($_SESSION['id']) || $grade < 1) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}
$id_user = $_SESSION['id'];

if (isset($_GET['erreur']) && !empty($_GET['erreur'])) {
    $erreur = $_GET['erreur'];
    if ($erreur == "toohigh")
        $errmsg = "<img src=\"https://media.giphy.com/media/8abAbOrQ9rvLG/giphy.gif\" alt=\"Vous ne passerez pas !\"> </br> Serieusement ? Grade trop elevé.";
    else
        $errmsg = "Veuillez réessayer !";

}

$listuser = "";
$req = $bdd->prepare ('SELECT * FROM users WHERE grade <> :grade ');
$req->execute ([
    ':grade' => 0,
]);
while($res = $req->fetch()) {
    $pseudo = $res["pseudo"];
    $gradeUser = $res["grade"];
    $listuser = $listuser . "<tr> <td> " . $pseudo . " </td><td> " .  $gradeUser . " </td></tr> ";
}

$last = "";
$req = $bdd->prepare ('SELECT * FROM users WHERE 1 ORDER BY dateinscription DESC LIMIT 10');
$req->execute();
while($res = $req->fetch()) {
    $pseudo = $res["pseudo"];
    $last = $last. "<tr> <td> " . $pseudo . " </td></tr> ";
}

$req = $bdd->prepare ('SELECT count(*) FROM users WHERE 1');
$req->execute ();
$res = $req->fetch();
$nbuser = $res[0];

$req = $bdd->prepare ('SELECT count(*) FROM federated_users WHERE 1');
$req->execute ();
$res = $req->fetch();
$nbfederated = $res[0];

$req = $bdd->prepare ('SELECT count(*) FROM images WHERE 1');
$req->execute ();
$res = $req->fetch();
$nbposts = $res[0];
$showPage = false;
if($grade >= 5)
	$showPage = true;
