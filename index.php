<!DOCTYPE html>
<html lang="fr">

<script src="bower_components/clipboard/dist/clipboard.min.js"></script>
<script src="common_card.js"></script>

<?php
	//head + navbar
	include 'includes/header.php';

	//input caché pour savoir si user connecté
	$id_user = $_SESSION['id'];
	if (!$id_user)
		echo "<input id='connected' value='no' hidden/>";
	else
		echo "<input id='connected' value='yes' hidden/>";
	
	//input caché pour savoir la méthode de sort
	if($_GET['sort']) {
		$sort = $_GET['sort'];
		if($sort == "new")
			echo "<input id='sort' value='new' hidden/>";
		else if($sort == "random")
			echo "<input id='sort' value='random' hidden/>";
		else
			echo "<input id='sort' value='hot' hidden/>";
	} else {
		echo "<input id='sort' value='hot' hidden/>";
	}
?> 

<!-- container principal -->
<div class="container" id="main_page">
	<!-- container qui aligne les cartes -->
	<div class="line-container" id="card_container">

	</div>
</div>

<script>


$(window).on("load", function() {
	//au chargement: affiche 30 cartes
	getCards(30);

});


$(window).scroll(function() {
	//quand l'user atteind le bas de la page, rajoute 20 cartes
	if($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
		getCards(20);
	}
});


//nb de cartes affichées
var currentIndex = 0;

//récupère les $size prochaines cartes depuis le serveur et les affiche
function getCards(size) {
	var sort = $("#sort").val();
	
	$.ajax({
		url: "requestajax.php",
		type: "POST",
		data: {
			size: size,
			sort: sort,
			startAt, currentIndex
		},
		contentType:"application/json; charset=utf-8",
		dataType:"json",
		success: function(data) {
			currentIndex += size;
			data = JSON.parse(data);

			for(var card in data)
				addCard(card);
		}
	})

}



//ajoute une carte à la page
function addCard(c) {
	var id= c.id;
	var titre = c.titre;
	var dateCreation = c.dateCreation;
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
	
		<div class='card-footer'><span class='points'>` + points +`</span><img class='phi-points' src='assets/phi.png'/>
			<button type='button' class='btn btn-primary upvote'><span class='glyphicon glyphicon-arrow-up'></span></button>
			<button type='button' class='btn btn-danger downvote'><span class='glyphicon glyphicon-arrow-down'></span></button>
			<div class='card-info'>il y a ` + temps + ` par <a href='user.php?id=` + idUser +`'>` + pseudoUser +`</a></div>
		</div>
	</div>`;


	var card = $(html);
	
	//vérifie l'ancien vote de l'user
	$.post(
		'check_vote.php',
		{
			id_image: id
		},
		returnVote,
		'text'
	);

	//ajoute la classe 'voted' à l'ancien vote
	function returnVote(ancien) {
		ancien = parseInt(ancien);
		if(ancien == 1)
			card.find(".upvote").addClass("voted");
		else if(ancien == -1)
			card.find(".downvote").addClass("voted");	
	}

	//assigne les fonctions de vote aux boutons
	card.find("#share_fb").click(shareFacebook);
	card.find("#share_twitter").click(shareTwitter);

	//assigne les fonctions de vote aux boutons
	card.find(".upvote").click(upVote);
	card.find(".downvote").click(downVote);

	//redirection quand on clique sur la carte vers la 'full screen'
	card.find('.card-content, .card-header').click(function() {
		if(!card.find("#share_clipboard").is(':hover')) //hack pour ne pas bloquer clipboardjs avec un stoppropagation
			window.location.href = 'view.php?id=' + id;
	});
	


	//fonctions hoverIn, hoverOut de l'overlay (fade in / out)
	card.find('.card-content').hover(function() {
			//HOVER IN
			$(this).find(".card-overlay").show();
	        $(this).find(".card-overlay").fadeTo(200, 1);
		},
		function() {
			//HOVER OUT
			card.find('[data-toggle="popover"]').popover("hide");
			$(this).find(".card-overlay").fadeTo(300, 0, function() {
				$(this).find(".card-overlay").hide();
			});
	});

	//fonctions hoverIn, hoverOut des boutons de partage (fade in / out)
	card.find('.card-share').hover(function() {
			//HOVER IN
	        $(this).fadeTo(100, 1);
		},
		function() {
			//HOVER OUT
			$(this).fadeTo(200, 0.7);
	});

	//ajoute la carte au container
	$("#card_container").append(card);

	//affiche l'image
	card.find('img').show();

	//initialise le clipboard lié au bouton copier
	var cb = new Clipboard(card.find("#share_clipboard").get(0));
	cb.on('success', function() {
		//change le titre du tooltip quand on a copié
		card.find("#share_clipboard").attr("title", "Lien copié !").tooltip('fixTitle').tooltip('show');
	});

	//remet le titre original au hoverOut
	card.find('#share_clipboard').on('mouseout', function() {
		$(this).attr("title", "Copier le lien").tooltip('fixTitle');
	})

	//initialise les tooltips des boutons de partage
	card.find(".card-share").tooltip();
}

</script>


</body>
</html>
