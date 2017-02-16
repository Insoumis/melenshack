<!DOCTYPE html>
<html>
<?php include 'includes/header.php';
include 'cardsinfo.php';

$idhash = $_GET['id'];



$json = getInfo($idhash);
$json = json_decode($json,true);

$id = $json['id'];
$titre = $json['titre'];
$idUser = $json['idUser'];
$pseudoUser = $json['pseudoUser'];
$urlSource = $json['urlSource'];
$points = $json['pointsTotaux'];


echo "<input id='id' value='$id' hidden/>";


$now = getdate();
$then = date_parse($json['dateCreation']);

$temps= "";

if($now['year'] != $then['year']) {
		$temps = $now['year'] - $then['year'];
		if($temps == 1)	
			$temps = $temps . " an";
		else
			$temps = $temps . " années";
	} else if($now['mon'] != $then['month']) {
		$temps = $now['mon'] - $then['month'];
		$temps = $temps . " mois";
	} else if($now['mday'] != $then['day']) {
		$temps = $now['mday'] - $then['day'];
		if($temps == 1)
			$temps = $temps . " jour";
		else
			$temps = $temps . " jours";
	} else if($now['hours'] != $then['hour']) {
		$temps = $now['hours'] - $then['hour'];
		if($temps == 1)
			$temps = $temps . " heure";
		else
			$temps = $temps . " heures";
	} else if($now['minutes'] != $then['minute']) {
		$temps = $now['minutes'] - $then['minute'];
		if($temps == 1)
			$temps = $temps . " minute";
		else
			$temps = $temps . " minutes";
	} else if($now['seconds'] != $then['second']) {
		$temps = $now['seconds'] - $then['second'];
		if($temps == 1)
			$temps = $temps . " seconde";
		else
			$temps = $temps . " secondes";
	} else {
		$temps = "1 nanoseconde";
	}
?>
<?php

$id_user = $_SESSION['id'];
if (!$id_user)
	echo "<input id='connected' value='no' hidden/>";
else
	echo "<input id='connected' value='yes' hidden/>";
	

?> 


<script src="common_card.js"></script>
<script src="bower_components/clipboard/dist/clipboard.min.js"></script>

<div id="main_page" class="container">

<div class="big-img-container" id=<?php echo "'$id'" ?>>
	<h1 class="big-img-titre"><?php echo $titre ?></h1>

	<div class="big-img-header">

		<div class="big-img-info">
			<span class="points"><?php echo $points; ?></span> <img class='phi-points' src='assets/phi.png'/>
			<button type='button' class='btn btn-primary upvote'><span class='glyphicon glyphicon-arrow-up'></span></button>
			<button type='button' class='btn btn-danger downvote'><span class='glyphicon glyphicon-arrow-down'></span></button>

			<br><div class='temps'> Il y a <?php echo "$temps par <a href='user.php?id=$idUser'>$pseudoUser</a>"; ?></div>
		<div class="big-share-group">	
		<img data-toggle='tooltip' title='Partager' src="assets/Facebook.png" class="big-share" id="share_fb"/>
		<img data-toggle='tooltip' title='Partager' src="assets/Twitter.png" class="big-share" id="share_twitter"/>
		<img data-clipboard-text=<?php echo "'http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]'"; ?> data-toggle='tooltip' title='Copier le lien' src="assets/Clipboard.png" class="big-share" id="share_clipboard"/>
		</div>
		
		</div>
	</div>
	<center><img class="big-img" src=<?php echo "'$urlSource'"; ?> /></center>

</div>

</div>

<script>
var id = $('#id').val();

//vérifie l'ancien vote
$.post(
	'check_vote.php',
	{
		id_image: id
	},
	returnVote,
	'text'
);

function returnVote(ancien) {
	ancien = parseInt(ancien);
	if(ancien == 1)
		$(".upvote").addClass("voted");
	else if(ancien == -1)
		$(".downvote").addClass("voted");	
}

$(window).on('load', function() {


//VOTES
$(".upvote").click(upVote);
$(".downvote").click(downVote);
//////////////

$("#share_fb").click(shareFacebook);
$("#share_twitter").click(shareTwitter);


$(".big-share").tooltip();

var cb = new Clipboard($("#share_clipboard").get(0));
cb.on('success', function() {
	$("#share_clipboard").attr("title", "Lien copié !").tooltip('fixTitle').tooltip('show');
});


$('#share_clipboard').on('mouseout', function() {
	$(this).attr("title", "Copier le lien").tooltip('fixTitle');
});



});
</script>

</html>
