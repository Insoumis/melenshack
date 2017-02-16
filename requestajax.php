<?php
include("includes/identifiants.php");
include_once("includes/constants.php");
include("cardsinfo.php");



if (empty($_POST['sort']) || !is_numeric($_POST['startIndex']) || !is_numeric($_POST['size'])) {
    exit();
}
$sort = htmlspecialchars($_POST['sort']);
$startIndex = $_POST['startIndex'];
$size = $_POST['size'];


if ($sort == "hot") {

    $req = $bdd->query ('SELECT nom_hash FROM images ORDER BY pointsTotaux DESC LIMIT ' . $startIndex . ',' .  $size );

    while ($resultat = $req->fetch()) {
        echo getInfo($resultat["nom_hash"]).'</br>';
    }

} elseif ($sort == "new") {

    $req = $bdd->query ('SELECT nom_hash FROM images ORDER BY date_creation DESC LIMIT ' . $startIndex . ',' . $size );

    while ($resultat = $req->fetch()) {
       echo getInfo($resultat["nom_hash"]).'</br>';
    }

} elseif ($sort == "random") {

    $req = $bdd->query ('SELECT nom_hash FROM images ORDER BY RAND() DESC LIMIT ' . $size );

    while ($resultat = $req->fetch()) {
        echo getInfo($resultat["nom_hash"]).'</br>';
    }
}

?>