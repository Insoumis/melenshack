<?php
include("includes/identifiants.php");
include_once("includes/constants.php");
include("cardsinfo.php");



if (empty($_POST['sort'])) {
    exit();
}
$sort = htmlspecialchars($_POST['sort']);

if ($sort == "hot") {

    $req = $bdd->query ('SELECT id FROM images ORDER BY nb_vote_positif LIMIT '.$_POST['startIndex']. ',' . ( $_POST['startIndex'] + $_POST['size'] ));

    while ($resultat = $req->fetch()) {
        echo getInfo(sha1($resultat["id"].SALT_ID)).'</br>';
    }

} elseif ($sort == "new") {

    $req = $bdd->query ('SELECT id FROM images ORDER BY date_creation DESC LIMIT '.$_POST['startIndex']. ',' . ( $_POST['startIndex'] + $_POST['size'] ));

    while ($resultat = $req->fetch()) {
       echo getInfo(sha1($resultat["id"].SALT_ID)).'</br>';
    }

} elseif ($sort == "random") {

    $req = $bdd->query ('SELECT id FROM images ORDER BY RAND() DESC LIMIT '.$_POST['size'] );

    while ($resultat = $req->fetch()) {
        echo getInfo(sha1($resultat["id"].SALT_ID)).'</br>';
    }
}

?>