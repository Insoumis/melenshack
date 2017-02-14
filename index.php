<!DOCTYPE html>
<html lang="fr">

<?php include 'includes/header.php'; ?>
<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '1849815745277262',
			xfbml      : true,
			version    : 'v2.8'
		});
	FB.AppEvents.logPageView();
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

<div id="main_page">
<div class="line-container" id="card_container">


</div>
</div>

<script>

urlBase = location.href.substring(0, location.href.lastIndexOf("/")+1);
$(window).on("load", function() {
	for(i = 0; i < 30; ++i)
		addCard(JSON.parse(j));

});

//fix pour popover qui doit etre cliqué 2 fois pour etre ouvert
$('body').on('hidden.bs.popover', function (e) {
	$(e.target).data("bs.popover").inState.click = false;
});

//date actuelle
var now = new Date();

//test
var j = `{
	"id": "30",
	"titre": "200 000 insoumis ! GG à tous !",
	"dateCreation": "2017-02-14 16:05:00",
	"pseudoUser": "Entropy",
	"idUser": "45",
	"url": "https://images-ext-2.discordapp.net/eyJ1cmwiOiJodHRwOi8vaW1hZ2Uubm9lbHNoYWNrLmNvbS9maWNoaWVycy8yMDE3LzA3LzE0ODcwMDg2MjgtbWVsdnNscG4wMy5wbmcifQ.1M3AX3KlZHHYRFo5JlECUB-vshE?width=390&height=467",
	"points": "352",
	"vote": "up"

}`;
// Exemple de cardsinfo.php :  {"id":"31","titre":"Ceci est un titre","dateCreation":"2017-02-14 23:59:17","pseudoUser":"aaaa","idUser":"1","urlTumbnail":"http:\/\/site.quelquechose\/vignettes\/e3ae30117a4064f5a5c425045af9e5cc54a9eba5.png","urlSource":"http:\/\/site.quelquechose\/images\/e3ae30117a4064f5a5c425045af9e5cc54a9eba5.png","pointsTotaux":0}
// Points totaux = nombre_vote_positif - nombre_vote_negatif

//partage l'image sur F
function shareFacebook(e) {
	//ne propage pas l'event à la carte
	e.stopPropagation();
	var card = $(e.target).closest(".card");
	var url = urlBase+"view.php?id=" + card.attr("id");

	FB.ui(
 	{
		method: 'share',
		mobile_iframe: true,
		hashtag: '#jlm2017',
		href: url
	}, function(response){});
}
function shareTwitter(e) {
	console.log("oui");
	e.stopPropagation();
	var card = $(e.target).closest(".card");
	var url = urlBase+"view.php?id=" + card.attr("id");
	window.open("https://twitter.com/share?url="+escape(url)+"&hashtags=jlm2017", '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');

}
function copyClipboard(e) {
	e.stopPropagation();
	var card = $(e.target).closest(".card");
	card.find('[data-toggle="popover"]').popover("toggle");
	var img = card.find(".card-img");
}

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
	var temps = "";

	var d = dateCreation.split(" ");
	
	//temps hh-mm-ss
	var t = d[1];

	//date yyyy-mm-dd
	d = d[0];

	var dd = d.split("-");
	var tt = t.split(":");

	var y = dd[0];
	var m = dd[1] - 1;
	d = dd[2];

	var h = tt[0];
	var min = tt[1];
	var s = tt[2];

	if(now.getFullYear() != y) {
		temps = now.getFullYear() - y;
		if(temps == 1)
			temps += " an";
		else
			temps += " années";
	} else if(now.getMonth() != m) {
		temps = now.getMonth() - m;
		temps += " mois";
	} else if(now.getDate() != d) {
		temps = now.getDate() - d;
		if(temps == 1)
			temps += " jour";
		else
			temps += " jours";
	} else if(now.getHours() != h) {
		temps = now.getHours() - h;
		if(temps == 1)
			temps += " heure";
		else
			temps += " heures";
	} else if(now.getMinutes() != min) {
		temps = now.getMinutes() - min;
		if(temps == 1)
			temps += " minute";
		else
			temps += " minutes";
	} else if(now.getSeconds() != s) {
		temps = now.getSeconds() - s;
		if(temps == 1)
			temps += " seconde";
		else
			temps += " secondes";
	} else {
		temps = "un certain temps";
	}

	var upvoteclass = (vote=="up")?"voted":"";
	var downvoteclass = (vote=="down")?"voted":"";


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
					<img id='share_fb' class='card-share'src='assets/Facebook.png'/>
					<img id='share_twitter' class='card-share' src='assets/Twitter.png'/>
					<img data-html=true data-toggle='popover' data-placement='left' data-content='<input type="text" value="` +urlBase+`view.php?id=`+id +`" class="clipinput"/>' class='card-share' id='share_clipboard' src='assets/Clipboard.png'/>
				</div>
			</div>
		</div>
	
		<div class='card-footer'>` + points +` <img class='phi-points' src='assets/phi.png'/>
			<button type='button' class='btn btn-primary upvote ` + upvoteclass + `'><span class='glyphicon glyphicon-arrow-up'></span></button>
			<button type='button' class='btn btn-danger downvote ` + downvoteclass + `'><span class='glyphicon glyphicon-arrow-down'></span></button>
			<span class='card-info'>il y a ` + temps + ` par <a href='user.php?id=` + idUser +`'>` + pseudoUser +`</a></span>
		</div>
	</div>`;

	var card = $(html);


	//assigne les events des boutons de partage
	card.find("#share_fb").click(shareFacebook);
	card.find("#share_twitter").click(shareTwitter);
	card.find("#share_clipboard").click(copyClipboard);

	//redirection quand on clique sur la carte vers la 'full screen'
	card.click(function() {
	});
	



	//VOTES
	card.find(".upvote").click(function(e) {
		e.stopPropagation();
		$(this).addClass("voted");
		$(this).parent().find(".downvote").removeClass("voted");
		//send vote to server
	})

	card.find(".downvote").click(function(e) {
		e.stopPropagation();
		$(this).addClass("voted");
		$(this).parent().find(".upvote").removeClass("voted");
		//send vote to server
	});
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

	card.find('[data-toggle="popover"]').popover();

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
