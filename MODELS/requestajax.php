<?php
include("includes/identifiants.php");
include_once("includes/constants.php");
include("cardsinfo.php");
include("check_grade.php");
ini_set('display_errors', 1);
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

if(!empty($_POST['id_user']))
	$id_user = $_POST['id_user'];
else
	$id_user = "";

if(!empty($_POST['id_user']))
	$id_user = $_POST['id_user'];
else
	$id_user = "";

if(!empty($_POST['tag'])) {
	$tag = $_POST['tag'];

	$tagsr = ".*".$tag.".*";
} else
	$tagsr = ".*";
$json = array();


if ($sort == "hot") {

    $req = $bdd->prepare ("SELECT nom_hash FROM images INNER JOIN users ON id_user = users.id WHERE (supprime=0 AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) AND (:id_user = '' OR id_user = :id_user) AND tags RLIKE :tagsr) ORDER BY pointsTotaux DESC LIMIT :startIndex , :size" );
	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':id_user', $id_user, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->execute();

    while ($resultat = $req->fetch()) {
        array_push($json, json_decode(getInfo($resultat["nom_hash"])));
    }
	echo json_encode($json);

} elseif ($sort == "new") {
    $req = $bdd->prepare ("SELECT nom_hash FROM images INNER JOIN users ON id_user = users.id WHERE (supprime=0 AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) AND (:id_user = '' OR id_user = :id_user) AND tags RLIKE :tagsr) ORDER BY date_creation DESC LIMIT :startIndex , :size" );
	
	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':id_user', $id_user, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->execute();


    

    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
    }
	echo json_encode($json);

} elseif ($sort == "random") {

    $req = $bdd->prepare ("SELECT nom_hash FROM images INNER JOIN users ON id_user = users.id WHERE (supprime=0 AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) AND (:id_user = '' OR id_user = :id_user) AND tags RLIKE :tagsr) ORDER BY RAND() DESC LIMIT :size" );
	
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':id_user', $id_user, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->execute();



    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
	}
	echo json_encode($json);
} elseif ($sort == "report" && $grade > 0) {
    $req = $bdd->prepare ("SELECT images.nom_hash, count(*) FROM images INNER JOIN report ON images.id = report.id_image INNER JOIN users ON images.id_user = users.id WHERE (supprime=0 AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) AND (:id_user = '' OR images.id_user = :id_user) AND tags RLIKE :tagsr) GROUP BY images.id ORDER BY count(*) DESC LIMIT :startIndex , :size");
	
	
	
	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':id_user', $id_user, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->execute();
    

    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
	}
	echo json_encode($json);
} elseif($sort == "deleted" && $grade > 0) {
	$req = $bdd->prepare ("SELECT nom_hash FROM images INNER JOIN users ON id_user = users.id WHERE (supprime=1 AND (titre LIKE :search OR tags LIKE :search OR users.pseudo LIKE :search) AND (:id_user = '' OR id_user = :id_user) AND tags RLIKE :tagsr) ORDER BY date_creation DESC LIMIT :startIndex , :size" );
	
	$req->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
	$req->bindParam(':size', $size, PDO::PARAM_INT);
	$req->bindParam(':search', $search, PDO::PARAM_STR);
	$req->bindParam(':id_user', $id_user, PDO::PARAM_STR);
	$req->bindParam(':tagsr', $tagsr, PDO::PARAM_STR);
	$req->execute();
    

    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
    }
	echo json_encode($json);


}
?>
