<!DOCTYPE html>
<html>
<?php include 'includes/header.php';
include 'cardsinfo.php';

$idhash = $_GET['id'];

$json = getInfo($idhash);
$json = json_decode($json,true);

$id = $json['id'];
$titre = $json['titre']
$idUser = $json['idUser'];
$pseudoUser = $json['pseudoUser'];
$urlSource = $json['urlSource'];
$points = $json['pointsTotaux'];




$now = getdate();
$then = getdate($json['dateCreation']);


if($now['year'] != then['year']) {
		$temps = $now['year'] - $then['year'];
		if($temps == 1)	
			$temps += " an";
		else
			$temps += " années";
	} else if($now['mon'] != $then['mon']) {
		$temps = $now['mon'] - $then['mon'];
		$temps += " mois";
	} else if($now['mday'] != $then['mday']) {
		$temps = $now['mday'] - $then['mday'];
		if($temps == 1)
			$temps += " jour";
		else
			$temps += " jours";
	} else if($now['hours'] != $then['hours']) {
		$temps = $now['hours'] - $then['hours'];
		if($temps == 1)
			$temps += " heure";
		else
			$temps += " heures";
	} else if($now['minutes'] != $then['minutes']) {
		$temps = $now['minutes'] - $then['minutes'];
		if($temps == 1)
			$temps += " minute";
		else
			$temps += " minutes";
	} else if($now['seconds'] != $then['seconds']) {
		$temps = $now['seconds'] - $then['seconds'];
		if($temps == 1)
			$temps += " seconde";
		else
			$temps += " secondes";
	} else {
		$temps = "à l'instant";
	}
?>

<div class="big-img-container">
	<h1 class="big-img-titre">200 000 insoumis ! GG à tous !</h1>

	<img class="big-img" src="http://s-www.republicain-lorrain.fr/images/F5653D5D-1E13-4B3B-87FD-6F0AD8C4D5E8/LRL_v0_13b/jean-luc-melenchon-a-tenu-un-double-meeting-ce-dimanche-photo-afp-1486304291.jpg" />

</div>









</html>
