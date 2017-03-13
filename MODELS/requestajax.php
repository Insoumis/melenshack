<?php
include("includes/identifiants.php");
include_once("includes/constants.php");
include("cardsinfo.php");
include("check_grade.php");

if (empty($_POST['sort']) || !is_numeric($_POST['startIndex']) || !is_numeric($_POST['size'])) {
    exit();
}
$sort = htmlspecialchars($_POST['sort']);
$startIndex = intval($_POST['startIndex']);
$size = intval($_POST['size']);

if(!empty($_POST['search']))
	$search = "%".$_POST['search']."%";
else
	$search = "%";

if(!empty($_POST['pseudo']))
	$pseudo = $_POST['pseudo'];
else
	$pseudo = "";

if(!empty($_POST['tag'])) {
	$tag = $_POST['tag'];

	$tagsr = ".*".$tag.".*";
} else
	$tagsr = ".*";
$json = array();


if ($sort == "top") {

	$req = $bdd->prepare ("
	SELECT nom_hash FROM images 
		INNER JOIN users ON id_user = users.id 
	WHERE (supprime=0 
			AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search)
			AND (:pseudo = '' OR pseudo = :pseudo) 
			AND tags RLIKE :tagsr)
			AND users.id NOT IN 
				(SELECT id_user FROM ban WHERE 1)
	ORDER BY pointsTotaux DESC LIMIT :startIndex , :size" );
	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->execute();

    while ($resultat = $req->fetch()) {
        array_push($json, json_decode(getInfo($resultat["nom_hash"])));
    }
	echo json_encode($json);

} elseif ($sort == "new") {
	$req = $bdd->prepare ("
	SELECT nom_hash FROM images 
		INNER JOIN users ON id_user = users.id 
	WHERE (supprime=0 
			AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) 
			AND (:pseudo = '' OR pseudo = :pseudo) 
			AND tags RLIKE :tagsr) 
			AND users.id NOT IN
				(SELECT id_user FROM ban WHERE 1)
	ORDER BY date_creation DESC LIMIT :startIndex , :size" );
	
	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->execute();



    

    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
    }
	echo json_encode($json);

} elseif ($sort == "random") {

	$req = $bdd->prepare ("
	SELECT nom_hash FROM images 
		INNER JOIN users ON id_user = users.id 
	WHERE (supprime=0 
			AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) 
			AND (:pseudo = '' OR pseudo = :pseudo) 
			AND tags RLIKE :tagsr) 
			AND users.id NOT IN
				(SELECT id_user FROM ban WHERE 1)
	ORDER BY RAND() DESC LIMIT :size" );
	
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->execute();



    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
	}
	echo json_encode($json);
} elseif ($sort == "report" && $grade > 0) {
	$req = $bdd->prepare ("
	SELECT images.nom_hash, count(*) FROM images 
		INNER JOIN report ON images.id = report.id_image 
		INNER JOIN users ON images.id_user = users.id 
	WHERE (supprime=0 
			AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) 
			AND (:pseudo = '' OR pseudo = :pseudo) 
			AND tags RLIKE :tagsr) 
			AND users.id NOT IN
				(SELECT id_user FROM ban WHERE 1)
	GROUP BY images.id ORDER BY count(*) DESC LIMIT :startIndex , :size");
	
	
	
	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->execute();
    

    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
	}
	echo json_encode($json);
} elseif($sort == "deleted" && $grade > 0) {
	$req = $bdd->prepare ("
	SELECT nom_hash FROM images 
		INNER JOIN users ON id_user = users.id 
	WHERE (supprime=1 
			AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) 
			AND (:pseudo = '' OR pseudo = :pseudo) 
			AND tags RLIKE :tagsr)
			AND users.id NOT IN
				(SELECT id_user FROM ban WHERE 1)
	ORDER BY date_creation DESC LIMIT :startIndex , :size" );
	
	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->execute();
    

    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
    }
	echo json_encode($json);


}
elseif ($sort == "hot") {

	$req = $bdd->prepare ("
	SELECT nom_hash FROM images 
		INNER JOIN users ON id_user = users.id 
	WHERE (supprime=0 
			AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) 
			AND (:pseudo = '' OR pseudo = :pseudo) 
			AND tags RLIKE :tagsr) 
			AND users.id NOT IN
				(SELECT id_user FROM ban WHERE 1)
	ORDER BY LOG10(ABS(nb_vote_positif - nb_vote_negatif) + 1) * SIGN(nb_vote_positif - nb_vote_negatif)
    + (UNIX_TIMESTAMP(date_creation) / 300000) DESC LIMIT :startIndex, :size" );

	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->execute();



	while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
	}
	echo json_encode($json);
}
?>
