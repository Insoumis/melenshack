<?php
include_once ("includes/identifiants.php");
include_once("includes/constants.php");

function getInfo($idhash) {

	try {
		$bdd = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch (PDOException $erreur) {
		echo 'Ce service est momentanément indisponible. Veuillez nous excuser pour la gêne occasionnée.';
	}

	if (empty($idhash)) {
		return -1;
	}
	$id = htmlspecialchars ($idhash); // $_GET['id'] = sha1(SALT_ID.$id) donc faut inclure include_once ("includes/constants.php"); pour SALT_ID. "cardsinfo.php?id=". sha1(SALT_ID.$id)

	if (!isset($_SESSION)) {
		session_start ();
	}
	if (!$_SESSION) {
		exit();
	};
	$id_user = $_SESSION['id'];

	$req = $bdd->prepare ('SELECT images.*,users.pseudo,users.grade,users.dateinscription FROM images,users WHERE images.nom_hash = :nom_hash AND users.id = images.id_user');

	$req->execute ([
		':nom_hash' => $id,
	]);
	$resultat = $req->fetch ();

	if (!$id_user) {
		$resultat2 = null;
	} else {

		$req2 = $bdd->prepare ('SELECT * FROM vote WHERE id_image = :id_image AND id_user = :id_user');
		$req2->execute ([
			':id_image' => $resultat['id'],
			':id_user' => $id_user,
		]);
		$resultat2 = $req2->fetch ();
	}

	if (!$resultat) {
		return -1;
	}
	if (!$resultat2 OR $resultat2 == null) {
		$ancien_vote_bdd = 0;
	} else {
		$ancien_vote_bdd = $resultat2["vote"];
	}

	$id_pseudo = $resultat['id_user'];

	$req3 = $bdd->prepare("SELECT pointsTotaux FROM images WHERE id_user=:id_user");
	$req3->execute([
		':id_user' => $id_pseudo,
	]);

	$count = 0;
	$points = 0;

	while($res = $req3->fetch()) {
		$count = $count + 1;
		$points = $points + intval($res['pointsTotaux']);
	}

	if ($resultat["genre"] == "url") {

		$info = array(
			"idhash" => $id,
			"id" => $resultat["id"],
			"titre" => $resultat["titre"],
			"dateCreation" => $resultat["date_creation"],
			"pseudoUser" => $resultat["pseudo"],
			"idUser" => $resultat["id_user"],
			"urlThumbnail" => "vignettes/" . $id . '.' . $resultat["format"],
			"urlSource" => $resultat["url"],
			"pointsTotaux" => $resultat["pointsTotaux"],
			"supprime" => $resultat["supprime"],
			"tags" => $resultat["tags"],
			"pseudo" => $resultat["pseudo"],
			"ancien_vote" => $ancien_vote_bdd,
			"dateinscription" => $resultat["dateinscription"],
			"grade" => $resultat["grade"],
			'points' => $points,
			'posts' => $count,
		);

	} else {
		$info = array(
			"idhash" => $id,
			"id" => $resultat["id"],
			"titre" => $resultat["titre"],
			"dateCreation" => $resultat["date_creation"],
			"pseudoUser" => $resultat["pseudo"],
			"idUser" => $resultat["id_user"],
			"urlThumbnail" => "vignettes/" . $id . '.' . $resultat["format"],
			"urlSource" => "images/" . $id . '.' . $resultat["format"],
			"pointsTotaux" => $resultat["pointsTotaux"],
			"supprime" => $resultat["supprime"],
			"tags" => $resultat["tags"],
			"pseudo" => $resultat["pseudo"],
			"ancien_vote" => $ancien_vote_bdd,
			"inscription" => $resultat["dateinscription"],
			"grade" => $resultat["grade"],
			'points' => $points,
			'posts' => $count,
		);
	}
	$infojson = json_encode($info);

	return $infojson;

}
