<?php
include("includes/identifiants.php");
include_once("includes/constants.php");
include("cardsinfo.php");



if (empty($_GET['sort']) || !is_numeric($_GET['startIndex']) || !is_numeric($_GET['size'])) {
    exit();
}
$sort = htmlspecialchars($_GET['sort']);
$startIndex = $_GET['startIndex'];
$size = $_GET['size'];


if ($sort == "hot") {

    $req = $bdd->query ('SELECT nom_hash FROM images ORDER BY nb_vote_positif LIMIT ' . $startIndex . ',' .  $size );

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