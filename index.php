<!DOCTYPE html>
<html lang="fr">

<?php include 'includes/header.php'; ?>
<div id="main_page">
<div class="line-container" id="card_container">


</div>
</div>

<script>
var now = new Date();
var j = `{
	"id": "30",
	"titre": "200 000 insoumis ! GG à tous !",
	"dateCreation": "2017-02-14 16:05:00",
	"pseudoUser": "Entropy",
	"idUser": "45",
	"url": "https://media.giphy.com/media/3oriNVEGuyvUIMnn1u/source.gif",
	"points": "352",
	"vote": "up"

}`;

function addCard(c) {
	var id= c.id;
	var titre = c.titre;
	var dateCreation = c.dateCreation;;
	var pseudoUser = c.pseudoUser;
	var idUser = c.idUser;
	var points = c.points;
	var url = c.url;
	var vote = c.vote;
	

	var temps = "";

	var d = dateCreation.split(" ");
	var t = d[1];
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
					<img id='share_clipboard' class='card-share' src='assets/Clipboard.png'/>
				</div>
			</div>
		</div>
	
		<div class='card-footer'>
			` + points +` <img class='phi-points' src='assets/phi.png'/>
			<button type='button' class='btn btn-primary upvote'><span class='glyphicon glyphicon-arrow-up'></span></button>
			<button type='button' class='btn btn-danger downvote'><span class='glyphicon glyphicon-arrow-down'></span></button>
			<span class='card-info'>il y a ` + temps + ` par <a href='user.php?id=` + idUser +`'>` + pseudoUser +`</a></span>
		</div>
	</div>
	`;

	$("#card_container").append($(html));

}


function shareFacebook(e) {
	e.stopPropagation();
	var card = $(e.target).closest(".card");
	console.log("Share FB"+card);
}
function shareTwitter(e) {
	e.stopPropagation();
	var card = $(e.target).closest(".card");
	console.log("Share Twitter"+card);
}
function copyClipboard(e) {
	e.stopPropagation();
	var card = $(e.target).closest(".card");
	var img = card.find(".card-img");
	console.log("Copy clipboard "+img.attr('src'));
}

$(window).on("load", function() {



	addCard(JSON.parse(j));
	addCard(JSON.parse(j));
	addCard(JSON.parse(j));
	addCard(JSON.parse(j));
	addCard(JSON.parse(j));
	addCard(JSON.parse(j));
	addCard(JSON.parse(j));
	addCard(JSON.parse(j));
	addCard(JSON.parse(j));
	addCard(JSON.parse(j));
	addCard(JSON.parse(j));
	$("#share_fb").click(shareFacebook);
	$("#share_twitter").click(shareTwitter);
	$("#share_clipboard").click(copyClipboard);

	//redirections
	$(".card").each(function(i, c) {
		var id = $(this).attr("id");
		$(this).click(function() {
			window.location.href = "view.php?id="+id;
		});
	
	});



	//////////////


	//VOTES
	$(".upvote").click(function(e) {
		e.stopPropagation();
		$(this).addClass("voted");
		$(this).parent().find(".downvote").removeClass("voted");
		//send vote to server
	})

	$(".downvote").click(function(e) {
		e.stopPropagation();
		$(this).addClass("voted");
		$(this).parent().find(".upvote").removeClass("voted");
		//send vote to server
	});
	//////////////
	
	//OVERLAY
	
	function hoverIn(e) {
		$(e.target).show();
	}
	function hoverOut(e) {
		$(e.target).hide();
	}
	
	$('.card-content').hover(function() {
			$(this).find(".card-overlay").show();
	        $(this).find(".card-overlay").fadeTo(200, 1);
	
		},
		function() {
			$(this).find(".card-overlay").fadeTo(300, 0, function() {
				$(this).find(".card-overlay").hide();
			});
	});
	$('.card-share').hover(function() {
	        $(this).fadeTo(100, 1);
		},
		function() {
			$(this).fadeTo(200, 0.7);
	});
	/////////////////////

	//centre l'image pour cropper à droite et à gauche
	$(".card-img").each(function(i, img) {
		$(img).css({
			position: "relative",
			left: ($(img).parent().width() - $(img).width()) / 2
		});
		$(img).show();
	});

});


//AJAX
/*
style de la requete:
{
	"sort": "hot"/"new"/"random",       methode de tri
	"size": 10							nbr d'images demandées
	"startAt": 20						index 

}

*/

</script>
<script>
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
