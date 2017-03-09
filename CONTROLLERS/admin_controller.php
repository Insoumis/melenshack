<?php
include_once("MODELS/includes/identifiants.php");
include_once("MODELS/includes/constants.php");
require_once ('MODELS/includes/token.class.php');
include 'MODELS/check_grade.php';

$token_A = Token::generer('admin');
$errmsg = "";

if (!isset($_SESSION)) {
    session_start ();
}
if (!$_SESSION) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}
$id_user = $_SESSION['id'];
if (!$id_user || $grade < 1) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}

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