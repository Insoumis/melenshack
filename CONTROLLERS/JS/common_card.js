/*

SCRIPT COMMUN DE PARTAGE / VOTE DES CARTES

*/


var urlBase = location.href.substring(0, location.href.lastIndexOf("/")+1);

//date actuelle
var now = new Date();


//Facebook SDK pour le partage
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
	js.src = "//connect.facebook.net/fr_FR/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


//Fonctions de partage
function shareFacebook(e) {
	//ne propage pas l'event à la carte
	e.stopPropagation();
	var card = $(e.target).closest(".card, .big-card, .big-img-container");
	var url = urlBase+"view.php?id=" + card.attr("id");

	FB.ui(
 	{
		method: 'share',
		hashtag: '#jlm2017',
		href: url
	}, function(response){});
}

function shareTwitter(e) {
	e.stopPropagation();
	var card = $(e.target).closest(".card, .big-card, .big-img-container");
	var url = urlBase+"view.php?id=" + card.attr("id");
	window.open("https://twitter.com/share?url="+escape(url)+"&hashtags=jlm2017", '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');

}

function shareGplus(e) {
	e.stopPropagation();
	var card = $(e.target).closest(".card, .big-card, .big-img-container");
	var url = urlBase+"view.php?id=" + card.attr("id");
	window.open("https://plus.google.com/share?url="+escape(url), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');


}




//Retourne un string du temps passé depuis un timestamp
function getTimeElapsed(date, minimise=false) {

	date = new Date(date);
	var diff = now - date;
	
	diff = Math.floor(diff/1000);
	var s = diff % 60;
	
	diff = Math.floor((diff-s)/60);
	var min = diff % 60;
	
	diff = Math.floor((diff-min)/60);
	var h = diff % 24;
	
	diff = Math.floor((diff-h)/24);
	var d = diff % 30;
	
	diff = Math.floor((diff-d)/30);
	var m = diff % 12;
	
	diff = Math.floor((diff-m)/12);
	var y = diff;

	if(y) {
		temps = y;
		if(minimise) {
			return temps+"a.";
		}
		if(temps == 1)
			temps += " an";
		else
			temps += " années";
	} else if(m) {
		temps = m;
		if(minimise) {
			return temps+"m.";
		}
		temps += " mois";
	} else if(d) {
		temps = d;
		if(minimise) {
			return temps+"j";
		}
		if(temps == 1)
			temps += " jour";
		else
			temps += " jours";
	} else if(h) {
		temps = h;
		if(minimise) {
			return temps+"h";
		}
		if(temps == 1)
			temps += " heure";
		else
			temps += " heures";
	} else if(min) {
		temps = min;
		if(minimise) {
			return temps+"m";
		}
		if(temps == 1)
			temps += " minute";
		else
			temps += " minutes";
	} else if(s) {
		temps = s;
		if(minimise) {
			return temps+"s";
		}
		if(temps == 1)
			temps += " seconde";
		else
			temps += " secondes";
	} else {
		if(minimise) {
			return "0";
		}
		temps = "à l'instant";
	}


	return temps;
}
function thumbUp(id, card) {
	var btn = card.find('.card-thumb-up');

	if($('#connected').val() == "no") {
		showVoteError();
		return;
	}
	var currentV = card.find('.big-card-points, .points').html();

	if(!currentV) {
		currentV = card.find('.card-points').html();
	
	}

	if(!btn.hasClass("voted")) {
		btn.addClass("voted");
		btn.css('color', '');

		if(card.find(".card-thumb-down").hasClass("voted")) 
			currentV ++;
		
	
		currentV++;
	
					
		card.find(".card-thumb-down").removeClass("voted");
		if(!card.hasClass('big-img-container')) {
			card.css('background', '#23b9d0');
			card.stop(true, false).animate({backgroundColor: '#ffffff'}, 700);
		} else {
			card.parent().css('background', '#23b9d0');
			card.parent().stop(true, false).animate({backgroundColor: 'rgba(255, 255, 255, 0)'}, 700);
		}
		vote(id, 1);

	} else {
		currentV--;
		btn.removeClass('voted');
		btn.css('color', 'black');
		btn.tooltip('hide');
		btn.on('mouseout', function() {
			btn.css('color', '');
		});

		vote(id, 0);
	}

	card.find('.big-card-points, .card-points, .points').html(currentV);
}

	
function thumbDown(id, card) {
	var btn = card.find('.card-thumb-down');

	if($('#connected').val() == "no") {
		showVoteError();
		return;
	}
	var currentV = card.find('.big-card-points, .points').html();
	if(!currentV)
		currentV = card.find('.card-points').html();
	
	if(!btn.hasClass("voted")) {
		btn.addClass("voted");
		btn.css('color', '');
		
		if(card.find(".card-thumb-up").hasClass("voted"))
			currentV --;
	
		currentV--;
					
		card.find(".card-thumb-up").removeClass("voted");
		
		if(!card.hasClass('big-img-container')) {
			card.css('background', '#e23d22');
			card.stop(true, false).animate({backgroundColor: '#ffffff'}, 700);
		} else {
			card.parent().css('background', '#e23d22');
			card.parent().stop(true, false).animate({backgroundColor: 'rgba(255, 255, 255, 0)'}, 700);
		}

		vote(id, -1);
	} else {
		currentV++;
		btn.removeClass('voted');
		btn.css('color', 'black');
		btn.tooltip('hide');
		btn.on('mouseout', function() {
			btn.css('color', '');
		});
		vote(id, 0);
	}
	card.find('.big-card-points, .card-points, .points').html(currentV);

}
	


function checkVote(card) {
	if(!card.attr('id'))
		return;
	
	$.post(
		'MODELS/check_vote.php',
		{idhash: card.attr('id')},
		returnVote,
		'text'
	);
	
	function returnVote(ancien) {
		ancien = parseInt(ancien);
		if(ancien == 1) {
			$(card).find('.card-thumb-up').addClass('voted');
			$(card).find('.card-thumb-down').removeClass('voted');
		} else if(ancien == -1) {
			$(card).find('.card-thumb-down').addClass('voted');
			$(card).find('.card-thumb-up').removeClass('voted');	
		} else {
			$(card).find('.card-thumb-down').removeClass('voted');
			$(card).find('.card-thumb-up').removeClass('voted');	
		}
	}
}

function checkVotelol(card,ancien) {
	
		ancien = parseInt(ancien);
		if(ancien == 1) {
			$(card).find('.card-thumb-up').addClass('voted');
			$(card).find('.card-thumb-down').removeClass('voted');
		} else if(ancien == -1) {
			$(card).find('.card-thumb-down').addClass('voted');
			$(card).find('.card-thumb-up').removeClass('voted');
		} else {
			$(card).find('.card-thumb-down').removeClass('voted');
			$(card).find('.card-thumb-up').removeClass('voted');
		}
}


//envoie vote au serveur
function vote(id, vote) {
	$.post(
		'MODELS/vote_conf.php',
		{idhash: id,
		 vote: vote},
		'text'
	);
}


//affiche erreur si pas loggé
function showVoteError() {
	var e = `<div id='voteerror' class='alert alert-danger erreur'>
	      <a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
		  Vous devez être connecté pour pouvoir voter. <a href='login.php'>Se connecter</a>.
		  </div>`;

	var erreur = $(e);
	$('#main_page').prepend(erreur);

	//fade out au bout de 2s
	erreur.delay(2000).animate({'opacity': '0'}, 1000, function() {
		erreur.remove();		
	});
}
