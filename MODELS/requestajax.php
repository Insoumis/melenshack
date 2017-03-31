<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("includes/identifiants.php");
include_once("includes/constants.php");
include("cardsinfo.php");
include("check_grade.php");

if (empty($_REQUEST['sort']) || !is_numeric($_REQUEST['startIndex']) || !is_numeric($_REQUEST['size'])) {
    exit();
}
$sort = htmlspecialchars($_REQUEST['sort']);
$startIndex = intval($_REQUEST['startIndex']);
$size = intval($_REQUEST['size']);

$hidden = 0;
if(!empty($_REQUEST['search'])) {
	$search = "%".urldecode($_REQUEST['search'])."%";
	$hidden = 1;
} else
	$search = "%";

if(!empty($_REQUEST['pseudo'])) {
	$pseudo = urldecode($_REQUEST['pseudo']);
	$hidden = 1;	
} else
	$pseudo = "";

if(!empty($_REQUEST['tag'])) {
	$tag = urldecode($_REQUEST['tag']);
	$u = strtoupper($tag);
	//tags caches visibles
	$hidden = 1;
	$tagsr = ".*".$tag.".*";
} else
	$tagsr = ".*";
$json = array();

//tags caches
$hiddenstr = '.*(concours|18mars|ressources|Rennes).*';

if ($sort == "top") {

	$req = $bdd->prepare ("
	SELECT nom_hash FROM images 
		INNER JOIN users ON id_user = users.id 
	WHERE (supprime=0 
			AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search)
			AND (:pseudo = '' OR pseudo = :pseudo OR pseudo_author = :pseudo) 
			AND ((:hidden=0 AND tags RLIKE :tagsr 
				AND tags NOT RLIKE :hiddenstr)
				OR (:hidden=1 AND tags RLIKE :tagsr))
			AND users.id NOT IN 
				(SELECT id_user FROM ban WHERE 1))
	ORDER BY pointsTotaux DESC LIMIT :startIndex , :size" );
	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->bindParam(':hiddenstr', $hiddenstr, PDO::PARAM_STR);
	$req->bindParam(':hidden', $hidden, PDO::PARAM_BOOL);
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
			AND (:pseudo = '' OR pseudo = :pseudo OR pseudo_author = :pseudo) 
			AND ((:hidden=0 AND tags RLIKE :tagsr 
				AND tags NOT RLIKE :hiddenstr)
				OR (:hidden=1 AND tags RLIKE :tagsr))
			AND users.id NOT IN
				(SELECT id_user FROM ban WHERE 1))
	ORDER BY date_modif DESC LIMIT :startIndex , :size" );
	
	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->bindParam(':hiddenstr', $hiddenstr, PDO::PARAM_STR);
	$req->bindParam(':hidden', $hidden, PDO::PARAM_BOOL);
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
			AND (:pseudo = '' OR pseudo = :pseudo OR pseudo_author = :pseudo) 
			AND ((:hidden=0 AND tags RLIKE :tagsr 
				AND tags NOT RLIKE :hiddenstr)
				OR (:hidden=1 AND tags RLIKE :tagsr))
			AND users.id NOT IN
				(SELECT id_user FROM ban WHERE 1))
	ORDER BY RAND() DESC LIMIT :size" );
	
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->bindParam(':hiddenstr', $hiddenstr, PDO::PARAM_STR);
	$req->bindParam(':hidden', $hidden, PDO::PARAM_BOOL);
	$req->execute();



    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
	}
	echo json_encode($json);
} elseif ($sort == "report" && $grade >= 5) {
	$req = $bdd->prepare ("
	SELECT images.nom_hash, count(*) FROM images 
		INNER JOIN report ON images.id = report.id_image 
		INNER JOIN users ON images.id_user = users.id 
	WHERE (supprime=0 
			AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) 
			AND (:pseudo = '' OR pseudo = :pseudo OR pseudo_author = :pseudo) 
			AND tags RLIKE :tagsr
			AND users.id NOT IN
				(SELECT id_user FROM ban WHERE 1))
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
} elseif($sort == "deleted" && $grade >= 5) {
	$req = $bdd->prepare ("
	SELECT nom_hash FROM images 
		INNER JOIN users ON id_user = users.id 
	WHERE (supprime=1 
			AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) 
			AND (:pseudo = '' OR pseudo = :pseudo OR pseudo_author = :pseudo) 
			AND tags RLIKE :tagsr
			AND users.id NOT IN
				(SELECT id_user FROM ban WHERE 1))
	ORDER BY date_modif DESC LIMIT :startIndex , :size" );
	
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
	$coefredressement = 0;

	// Gros boost = 1, Boost moyen = 0.5, Boost faible = 0.2

	$req = $bdd->prepare ("
	SELECT nom_hash FROM images 
		INNER JOIN users ON id_user = users.id 
	WHERE (supprime=0 
			AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) 
			AND (:pseudo = '' OR pseudo = :pseudo OR pseudo_author = :pseudo) 
			AND ((:hidden=0 AND tags RLIKE :tagsr 
				AND tags NOT RLIKE :hiddenstr)
				OR (:hidden=1 AND tags RLIKE :tagsr))
			AND users.id NOT IN
				(SELECT id_user FROM ban WHERE 1))
	ORDER BY LOG10(ABS(nb_vote_positif - nb_vote_negatif) + 1) * SIGN(nb_vote_positif - nb_vote_negatif)
    + (UNIX_TIMESTAMP(date_modif) / 300000) + :coefredressement DESC LIMIT :startIndex, :size" );

	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->bindParam(':hiddenstr', $hiddenstr, PDO::PARAM_STR);
	$req->bindParam(':hidden', $hidden, PDO::PARAM_BOOL);
	$req->bindParam(':coefredressement', $coefredressement, PDO::PARAM_INT);
	$req->execute();



	while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
	}
	echo json_encode($json);
}
?>
