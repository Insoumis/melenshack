<?php
include ("includes/identifiants.php");

function getInfo($idhash) {

	if (empty($idhash)) {
		return -1;
	}

	$id = htmlspecialchars($idhash); // $_GET['id'] = sha1(SALT_ID.$id) donc faut inclure include_once ("includes/constants.php"); pour SALT_ID. "cardsinfo.php?id=". sha1(SALT_ID.$id)
	
	echo "test1";
	$req = $bdd->prepare('SELECT * FROM images WHERE nom_hash = :nom_hash');
	
	echo "test2";
	$req->execute([
	    'nom_hash' => $id,
	]);
	$resultat = $req->fetch();
	
	if (!$resultat)
	{
	    return -1;
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
	    "urlThumbnail" => __DIR__ ."/vignettes/".$id . '.'. $resultat["format"],
	    "urlSource" => __DIR__ ."/images/".$id. '.'. $resultat["format"],
	    "pointsTotaux" => ($resultat["nb_vote_positf"] - $resultat["nb_vote_negatif"]) ,
	);
	
	$infojson = json_encode($info);
	
	return $infojson;

}
