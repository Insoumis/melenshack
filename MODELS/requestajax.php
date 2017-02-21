<?php
include("includes/identifiants.php");
include_once("includes/constants.php");
include("cardsinfo.php");
include("check_grade.php");

if (empty($_POST['sort']) || !is_numeric($_POST['startIndex']) || !is_numeric($_POST['size'])) {
    exit();
}
$sort = htmlspecialchars($_POST['sort']);
$startIndex = $_POST['startIndex'];
$size = $_POST['size'];
$json = array();


if ($sort == "hot") {

    $req = $bdd->prepare ("SELECT nom_hash FROM images WHERE supprime=0 ORDER BY pointsTotaux DESC LIMIT " . $startIndex . " , " . $size );
    
	$req->execute([
        ':startIndex' => $startIndex,
		':size' => $size
    ]);

    while ($resultat = $req->fetch()) {
        array_push($json, json_decode(getInfo($resultat["nom_hash"])));
    }
	echo json_encode($json);

} elseif ($sort == "new") {
    $req = $bdd->query ("SELECT nom_hash FROM images WHERE supprime=0 ORDER BY date_creation DESC LIMIT " . $startIndex . " , ". $size );
    

    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
    }
	echo json_encode($json);

} elseif ($sort == "random") {

    $req = $bdd->query ("SELECT nom_hash FROM images WHERE supprime=0 ORDER BY RAND() DESC LIMIT " . $size );

    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
	}
	echo json_encode($json);
} elseif ($sort == "report" && $grade > 0) {
    $req = $bdd->query ("SELECT images.nom_hash, count(*) FROM images inner join report on images.id = report.id_image GROUP BY images.id ORDER BY count(*) DESC LIMIT " . $startIndex ." , " . $size);
    

    while ($resultat = $req->fetch()) {
		array_push($json, json_decode(getInfo($resultat["nom_hash"])));
	}
	echo json_encode($json);
}
?>
