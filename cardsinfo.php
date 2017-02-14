<?php
include ("includes/identifiants.php");

if (empty($_GET['id'])) {
    exit();
}
$id = htmlspecialchars($_GET['id']); // $_GET['id'] = sha1(SALT_ID.$id) donc faut inclure include_once ("includes/constants.php"); pour SALT_ID. "cardsinfo.php?id=". sha1(SALT_ID.$id)

$req = $bdd->prepare('SELECT * FROM images WHERE nom_hash = :nom_hash');
$req->execute([
    'nom_hash' => $id,
]);
$resultat = $req->fetch();

if (!$resultat)
{
    echo 'erreur';
    exit();
}

$req2 = $bdd->prepare('SELECT pseudo FROM users WHERE id = :id_user');
$req2->execute([
    'id_user' => $resultat["id_user"],
]);
$resultat2 = $req2->fetch();

$info = array(
    "id" => $resultat["id"],
    "titre" => $resultat["titre"],
    "dateCreation" => $resultat["date_creation"],
    "pseudoUser" => $resultat2["pseudo"],
    "idUser" => $resultat["id_user"],
    "urlThumbnail" => "http://site.quelquechose/vignettes/".$id . '.'. $resultat["format"],
    "urlSource" => "http://site.quelquechose/images/".$id. '.'. $resultat["format"],
    "pointsTotaux" => ($resultat["nb_vote_positf"] - $resultat["nb_vote_negatif"]) ,
);

$infojson = json_encode($info);
echo $infojson;