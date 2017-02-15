<!DOCTYPE html>
<html lang="fr">

<?php include 'includes/header.php'; ?>

<script src="bower_components/clipboard/dist/clipboard.min.js"></script>
<script src="common_card.js"></script>

<div id="main_page">
<div class="line-container" id="card_container">


</div>
</div>

<script>

$(window).on("load", function() {
	for(i = 0; i < 30; ++i)
		addCard(JSON.parse(j));

});

//fix pour popover qui doit etre cliqué 2 fois pour etre ouvert
$('body').on('hidden.bs.popover', function (e) {
	$(e.target).data("bs.popover").inState.click = false;
});

//test
var j = `{
	"id": "3e2562f322a323124f23d2311e3132",
	"titre": "200 000 insoumis ! GG à tous !",
	"dateCreation": "2017-02-14 16:05:00",
	"pseudoUser": "Entropy",
	"idUser": "45",
	"url": "https://images-ext-2.discordapp.net/eyJ1cmwiOiJodHRwOi8vaW1hZ2Uubm9lbHNoYWNrLmNvbS9maWNoaWVycy8yMDE3LzA3LzE0ODcwMDg2MjgtbWVsdnNscG4wMy5wbmcifQ.1M3AX3KlZHHYRFo5JlECUB-vshE?width=390&height=467",
	"points": "352",
	"vote": "up"

}`;
// Exemple de cardsinfo.php :  {"id":"5e123f5e3a13a213","titre":"Ceci est un titre","dateCreation":"2017-02-14 23:59:17","pseudoUser":"aaaa","idUser":"1","urlTumbnail":"http:\/\/site.quelquechose\/vignettes\/e3ae30117a4064f5a5c425045af9e5cc54a9eba5.png","urlSource":"http:\/\/site.quelquechose\/images\/e3ae30117a4064f5a5c425045af9e5cc54a9eba5.png","pointsTotaux":0}
// Points totaux = nombre_vote_positif - nombre_vote_negatif

//partage l'image sur F
//OVERLAY	
function hoverIn(e) {
	$(e.target).show();
}
function hoverOut(e) {
	$(e.target).hide();
}



//ajoute une carte à la page
function addCard(c) {
	var id= c.id;
	var titre = c.titre;
	var dateCreation = c.dateCreation;;
	var pseudoUser = c.pseudoUser;
	var idUser = c.idUser;
	var points = c.points;
	var url = c.url;
	var vote = c.vote;
	
	//string du temps passé depuis le post
	var temps = getTimeElapsed(dateCreation);

	
	//html d'une carte
	var html = `
	<div class='card' id='` + id + `'>
		<div class='card-header'>
			<h2 title='` + titre + `' class='card-title'>` + titre + `</h2>
		</div>
		
		<div class='card-content'>
			<img class='card-img' src='` + url +`'>
			<div class='card-overlay'>
				<div class='card-buttons'>
					<img data-toggle='tooltip' title='Partager' id='share_fb' class='card-share'src='assets/Facebook.png'/>
					<img data-toggle='tooltip' title='Partager' id='share_twitter' class='card-share' src='assets/Twitter.png'/>
					<img data-toggle='tooltip' title='Copier le lien' data-trigger='hover' data-clipboard-text="` +urlBase+`view.php?id=`+id +`" class='card-share' id='share_clipboard' src='assets/Clipboard.png'/>
				</div>
			</div>
		</div>
	
		<div class='card-footer'>` + points +` <img class='phi-points' src='assets/phi.png'/>
			<button type='button' class='btn btn-primary upvote'><span class='glyphicon glyphicon-arrow-up'></span></button>
			<button type='button' class='btn btn-danger downvote'><span class='glyphicon glyphicon-arrow-down'></span></button>
			<span class='card-info'>il y a ` + temps + ` par <a href='user.php?id=` + idUser +`'>` + pseudoUser +`</a></span>
		</div>
	</div>`;

	var card = $(html);

	
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
			card.find(".upvote").addClass("voted");
		else if(ancien == -1)
			card.find(".downvote").addClass("voted");	
	}

	

	//assigne les events des boutons de partage
	card.find("#share_fb").click(shareFacebook);
	card.find("#share_twitter").click(shareTwitter);

	//redirection quand on clique sur la carte vers la 'full screen'
	card.click(function() {
		if(!card.find("#share_clipboard").is(':hover')) //hack pour ne pas bloquer clipboardjs avec un stoppropagation
			window.location.href = 'view.php?id=' + id;
	});
	



	//VOTES
	card.find(".upvote").click(upVote);

	card.find(".downvote").click(downVote);
	//////////////
	
	
	
	card.find('.card-content').hover(function() {
			$(this).find(".card-overlay").show();
	        $(this).find(".card-overlay").fadeTo(200, 1);
	
		},
		function() {
			card.find('[data-toggle="popover"]').popover("hide");
			$(this).find(".card-overlay").fadeTo(300, 0, function() {
				$(this).find(".card-overlay").hide();
			});
	});
	card.find('.card-share').hover(function() {
	        $(this).fadeTo(100, 1);
		},
		function() {
			$(this).fadeTo(200, 0.7);
	});
	/////////////////////

	//ajoute la carte au container
	$("#card_container").append(card);
	
	//centre l'image pour cropper à droite et à gauche
	card.find(".card-img").each(function(i, img) {
		$(img).css({
			position: "relative",
		});
		$(img).show();
	});

	var cb = new Clipboard(card.find("#share_clipboard").get(0));
	cb.on('success', function() {
		card.find("#share_clipboard").attr("title", "Lien copié !").tooltip('fixTitle').tooltip('show');
	});

	card.find('#share_clipboard').on('mouseout', function() {
		$(this).attr("title", "Copier le lien").tooltip('fixTitle');
	})
	card.find(".card-share").tooltip();
}


$(window).scroll(function() {
	if($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
		for(i = 0; i < 20; ++i)
			addCard(JSON.parse(j));	
	}
});

function getParameterByName(name) {
	
	var url = window.location.href;
	
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	results = regex.exec(url);
	if (!results) return null;
	if (!results[2]) return '';
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}

var sort = getParameterByName("sort");

//change l'onglet actif
if(sort == null || sort == "hot") {
	$("#hot").addClass("actif");
} else if(sort == "new") {
	$("#new").addClass("actif");
} else if(sort == "random") {
	$("#random").addClass("actif");
}

</script>
</body>
</html>
