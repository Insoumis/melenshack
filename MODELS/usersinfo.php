<?php

include_once("includes/identifiants.php");



$id = intval($_POST['id']);
if(!$id)
	exit;


$req = $bdd->prepare("SELECT * from users WHERE id=:id");
$req->execute([
	':id' => $id
]);

$res = $req->fetch();


$pseudo = $res['pseudo'];
$inscription = $res['dateinscription'];
$grade = $res['grade'];

$req = $bdd->prepare("SELECT pointsTotaux from images WHERE id_user=:id");
$req->execute([
	':id' => $id
]);

$count = 0;
$points = 0;

while($res = $req->fetch()) {
	$count = $count + 1;
	$points = $points + intval($res['pointsTotaux']);
}


$data = [
	'id' => $id,
	'pseudo' => $pseudo,
	'grade' => $grade,
	'inscription' => $inscription,
	'points' => $points,
	'posts' => $count
];

echo json_encode($data);
