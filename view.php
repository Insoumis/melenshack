<?php
require 'header.php';

require 'CONTROLLERS/view_controller.php';

require 'VIEWS/view_view.php';

?>

<script src='common_card.js'></script>
<script>
//A FAIRE : FUSIONNER CE SCRIPT AVEC COMMON CARDS

//id de l'image
var id = $('.big-img-container').attr('id');

//vérifie l'ancien vote
$.post(
	'MODELS/check_vote.php',
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

	//assigne les fonctions de vote aux boutons
	$(".upvote").click(upVote);
	$(".downvote").click(downVote);

	//assigne les fonctions de partage aux boutons
	$("#share_fb").click(shareFacebook);
	$("#share_twitter").click(shareTwitter);


	//initialise les tooltips des boutons de partage
	$(".big-share").tooltip();

	//initialise le clipboard pour pouvoir copier
	//et change le titre en fonction du clic / mouseOut
	var cb = new Clipboard($("#share_clipboard").get(0));
	cb.on('success', function() {
		$("#share_clipboard").attr("title", "Lien copié !").tooltip('fixTitle').tooltip('show');
	});

	$('#share_clipboard').on('mouseout', function() {
		$(this).attr("title", "Copier le lien").tooltip('fixTitle');
	});

});
</script>
