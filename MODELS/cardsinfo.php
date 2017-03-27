<?php
include_once ("includes/identifiants.php");
include_once("includes/constants.php");

function getInfo($idhash) {

    global $bdd;

	if (empty($idhash)) {
		return -1;
	}
	$id = htmlspecialchars ($idhash); // $_GET['id'] = sha1(SALT_ID.$id) donc faut inclure include_once ("includes/constants.php"); pour SALT_ID. "cardsinfo.php?id=". sha1(SALT_ID.$id)

	if (!isset($_SESSION)) {
		session_start ();
	}

	$req = $bdd->prepare ('SELECT images.*,users.pseudo,users.grade,users.dateinscription FROM images INNER JOIN users ON users.id=images.id_user WHERE images.nom_hash = :nom_hash');

	$req->execute ([
		':nom_hash' => $id,
	]);
	$resultat = $req->fetch ();
	
	if (!$resultat) {
		return -1;
	}
	
	if (!isset($_SESSION['id'])) {
		$resultat2 = null;
		$resultat3 = null;
	} else {

		$req2 = $bdd->prepare ('SELECT * FROM vote WHERE id_image = :id_image AND id_user = :id_user');
		$req2->execute ([
			':id_image' => $resultat['id'],
			':id_user' => $_SESSION['id'],
		]);
		$resultat2 = $req2->fetch ();
        
        $req = $bdd->prepare ('SELECT * FROM report WHERE id_image = :id_image AND id_user = :id_user');
        $req->execute ([
            ':id_image' => $resultat['id'],
            ':id_user' => $_SESSION['id'],
        ]);

		$resultat3 = $req->fetch ();

	}

	
	if (!$resultat2 or $resultat2 == null) {
		$ancien_vote_bdd = 0;
	} else {
		$ancien_vote_bdd = $resultat2["vote"];
	}
	
	if (!$resultat3 or $resultat3 == null) {
		$report = 0;
	} else {
		$report = 1;
	}


	$id_pseudo = $resultat['id_user'];

	$req3 = $bdd->prepare("SELECT pointsTotaux FROM images WHERE id_user=:id_user AND supprime='0'");
	$req3->execute([
		':id_user' => $id_pseudo,
	]);

	$count = 0;
	$points = 0;

	while($res = $req3->fetch()) {
		$count = $count + 1;
		$points = $points + intval($res['pointsTotaux']);
	}

	$cb = "";
	if($resultat['date_creation'] != $resultat['date_modif'])
		$cb = '?'.substr(md5($resultat['date_modif']), 0, 3);
	if ($resultat["genre"] == "url") {

		$info = array(
			"idhash" => $id,
			"id" => $resultat["id"],
			"titre" => $resultat["titre"],
			"dateCreation" => $resultat["date_modif"],
			"pseudoUser" => $resultat["pseudo"],
			"pseudoAuthor" => $resultat["pseudo_author"],
			"idUser" => $resultat["id_user"],
			"urlThumbnail" => "/vignettes/" . $id . '.' . $resultat["format"].$cb,
			"urlSource" => $resultat["url"],
			"type" => "url",
			"pointsTotaux" => $resultat["pointsTotaux"],
			"supprime" => $resultat["supprime"],
			"tags" => $resultat["tags"],
			"ancien_vote" => $ancien_vote_bdd,
			"ancien_report" => $report,
			"inscription" => $resultat["dateinscription"],
			"grade" => $resultat["grade"],
			'pointsUser' => $points,
			'posts' => $count,
		);

	} else {
		$info = array(
			"idhash" => $id,
			"id" => $resultat["id"],
			"titre" => $resultat["titre"],
			"dateCreation" => $resultat["date_modif"],
			"pseudoUser" => $resultat["pseudo"],
			"pseudoAuthor" => $resultat["pseudo_author"],
			"idUser" => $resultat["id_user"],
			"urlThumbnail" => "/vignettes/" . $id . '.' . $resultat["format"].$cb,
			"urlSource" => "/images/" . $id . '.' . $resultat["format"].$cb,
			"type" => $resultat["format"],
			"pointsTotaux" => $resultat["pointsTotaux"],
			"supprime" => $resultat["supprime"],
			"tags" => $resultat["tags"],
			"ancien_vote" => $ancien_vote_bdd,
			"ancien_report" => $report,
			"inscription" => $resultat["dateinscription"],
			"grade" => $resultat["grade"],
			'pointsUser' => $points,
			'posts' => $count,
		);
	}
	$infojson = json_encode($info);

	return $infojson;

}
