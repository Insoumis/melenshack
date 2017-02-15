<!DOCTYPE html>
<html>
<?php include 'includes/header.php';
include 'cardsinfo.php';

$idhash = $_GET['id'];

echo "<input id='idhash' value='$idhash' hidden/>";


$json = getInfo($idhash);
$json = json_decode($json,true);

$id = $json['id'];
$titre = $json['titre'];
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
<script src="common_card.js"></script>
<script src="bower_components/clipboard/dist/clipboard.min.js"></script>


<div class="big-img-container" id='fd2fd2sfds2'>
	<h1 class="big-img-titre">200 000 insoumis ! GG à tous !</h1>

	<div class="big-img-header">

		<div class="big-img-info">
			<span class="points">300</span> <img class='phi-points' src='assets/phi.png'/>
			<button type='button' class='btn btn-primary upvote'><span class='glyphicon glyphicon-arrow-up'></span></button>
			<button type='button' class='btn btn-danger downvote'><span class='glyphicon glyphicon-arrow-down'></span></button>
			<br><span class='temps'> Il y a 3 heures par <a href='user.php?id=35'>Entropy</a></span>

		<div class="big-share-group">	
		<img data-toggle='tooltip' title='Partager' src="assets/Facebook.png" class="big-share" id="share_fb"/>
		<img data-toggle='tooltip' title='Partager' src="assets/Twitter.png" class="big-share" id="share_twitter"/>
		<img data-clipboard-text="owii" data-toggle='tooltip' title='Copier le lien' src="assets/Clipboard.png" class="big-share" id="share_clipboard"/>
		</div>
		
		</div>
	</div>
	<center><img class="big-img" src="http://s-www.republicain-lorrain.fr/images/F5653D5D-1E13-4B3B-87FD-6F0AD8C4D5E8/LRL_v0_13b/jean-luc-melenchon-a-tenu-un-double-meeting-ce-dimanche-photo-afp-1486304291.jpg" /></center>

</div>



<script>
var id = $('#idhash').val();

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

//VOTES
$(".upvote").click(upVote);
$(".downvote").click(downVote);
//////////////

$("#share_fb").click(shareFacebook);
$("#share_twitter").click(shareTwitter);


var cb = new Clipboard($("#share_clipboard").get(0));
cb.on('success', function() {
	$("#share_clipboard").attr("title", "Lien copié !").tooltip('fixTitle').tooltip('show');
});


$('#share_clipboard').on('mouseout', function() {
	$(this).attr("title", "Copier le lien").tooltip('fixTitle');
});

$(".big-share").tooltip();
</script>



</html>
