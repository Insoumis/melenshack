<?php
include ("includes/identifiants.php");
include_once("includes/constants.php");

function getInfo($idhash) {

    try
    {
        $bdd = new PDO('mysql:host=' . DB_HOST . ';dbname='. DB_NAME .';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch (PDOException $erreur) {
            echo 'Ce service est momentanément indisponible. Veuillez nous excuser pour la gêne occasionnée.';
    }

	if (empty($idhash)) {
		return -1;
	}

	$id = htmlspecialchars($idhash); // $_GET['id'] = sha1(SALT_ID.$id) donc faut inclure include_once ("includes/constants.php"); pour SALT_ID. "cardsinfo.php?id=". sha1(SALT_ID.$id)
	
	$req = $bdd->prepare('SELECT * FROM images WHERE nom_hash = :nom_hash');
	
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
	    "idhash" => $id,
	    "titre" => $resultat["titre"],
	    "dateCreation" => $resultat["date_creation"],
	    "pseudoUser" => $resultat2["pseudo"],
	    "idUser" => $resultat["id_user"],
	    "urlThumbnail" => "/vignettes/".$id . '.'. $resultat["format"],
	    "urlSource" => "/images/".$id. '.'. $resultat["format"],
	    "pointsTotaux" => ($resultat["nb_vote_positf"] - $resultat["nb_vote_negatif"])
	);
	
	$infojson = json_encode($info);
	
	return $infojson;

}
