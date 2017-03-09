
//carte dont le menu share est ouvert
var currentCardShare;

//layout masonry
var gridLayout;

//nb de cartes affichées
var currentIndex = 0;

//plus de cartes à charger depuis la bdd
var fin = false;

//une requete est en cours
var fetching = false;

function initMasonry() {
	gridLayout = $('.card-container');
	gridLayout.masonry({
		itemSelector: '.card',
		columnWidth: 370,
		fitWidth: true,
		stagger: 30
	});
}
function updateMasonry() {
	$(gridLayout).masonry('reloadItems');
	$(gridLayout).masonry('layout');
}

function updateSearch() {
	$('.card').remove();
	fin = false;
	currentIndex = 0;
	getCards(10);

}

function closeBigCard() {
	$('.big-card-container').hide();
	updateVote($('.big-card').data('card'), $('.big-card').data('vote'));
}

$(document).ready(function() {

	initMasonry();

	$('#searchinput').on('keyup', updateSearch);

	$('.big-card-remove').hide();

	//ferme la bigimg si on clique à coté
	$('.big-card-container').click(closeBigCard);
	$('.big-card').click(function(e) {
		e.stopPropagation();
		$('#main_page .popover').popover('hide');
	});

	//ferme la bigimg si on clique sur la croix
	$('.big-card-close').click(closeBigCard);

	//signalement
	$('.big-card-signal').click(function() {
		report($('.big-card'));
	});

	//suppression definitive
	$('.big-card-sup-def').click(function() {
		if(supprime_def($('.big-card')) != -1) {
			closeBigCard();
			updateMasonry();
		}
	});

	//suppression
	$('.big-card-remove').click(function() {
		if(supprime_restore($('.big-card')) != -1) {
			closeBigCard();
			updateMasonry();
		}
	});

	//ban + suppression
	$('.big-card-ban').click(function() {
		if(ban_sup($('.big-card'), $('.big-card').data('id_user')) != -1) {
			closeBigCard();
			updateMasonry();
		}
	});

	//partages réseaux sociaux
	$('.big-card-facebook').click(shareFacebook);
	$('.big-card-twitter').click(shareTwitter);
	$('.big-card-gplus').click(shareGplus);

	//initalise les tooltips
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();
	
	//initialise le clipboard
	var c = new Clipboard($(".big-card-link").get(0));
	c.on('success', function() {
		//change le titre du tooltip quand on a copié
		$('.big-card-link').attr('title', 'Lien copié !').tooltip('fixTitle').tooltip('show');
	});
	
	//remet le titre original au hoverOut
	$('.big-card-link').on('mouseout', function() {
		$(this).attr('title', 'Copier le lien').tooltip('fixTitle');
	});
	//stop le gif playing meme si souris quitte vite
	$('body').hover(function() {
		$('.playing').mouseleave();
	});

	//ferme les share si on clique ailleurs
	$('.card-container').click(function() {
		if(currentCardShare != null)
			animateShare(currentCardShare);
	});

	//bouton THUMBUP
	$('.big-card').find(".card-thumb-up").click(function() {
		thumbUp($('.big-card').attr('id'), $('.big-card'));
		$($('.big-card').data('card')).find('.card-points').html($('.big-card').find('.big-card-points').html());
	});

	//bouton THUMBUP
	$('.big-card').find(".card-thumb-down").click(function() {
		thumbDown($('.big-card').attr('id'), $('.big-card'));
		$($('.big-card').data('card')).find('.card-points').html($('.big-card').find('.big-card-points').html());
	});


	$(document).click(function() {
		$('#main_page .popover').popover('hide');

	});

	//au chargement: affiche 30 cartes
	getCards(10);

});



//quand l'user atteind le bas de la page, rajoute 20 cartes
$(window).scroll(function() {
	if(!fin && $(window).scrollTop() + $(window).height() > $(document).height() - 20) {
		getCards(10);
	}
});


//récupère les $size prochaines cartes depuis le serveur et les affiche
function getCards(size) {
    fetching = true;

	var sort = $('#sort').val();
	var search = $('#searchinput').val();
	var pseudo = $('#search_pseudo').val();
	var tag = $('#search_tag').val();

	$.ajax({
		url: 'MODELS/requestajax.php',
		type: 'POST',
		data: {
			'size': size,
			'sort': sort,
			'startIndex': currentIndex,
			'search': search,
			'pseudo': pseudo,
			'tag': tag
		},
		success: function(data) {
			data = JSON.parse(data);
			var i = 0;
			for(x = 0; x < data.length; ++x) {
				if(!$('.card-container').has('#'+data[x].idhash).length) {
					addCard(data[x]);
					i++;
				}
			}
	    
            if(i < size) {
				fin = true;
			}
			currentIndex += i;

			var t = 0;
			$('.card').each(function(i, card) {
				t++;
			});
			if(t == 0) {
				$('#nothing').remove();
				$("#main_page").append($("<center><h3 id='nothing'>Rien n'a été trouvé.</h3></center>"));
			} else if(t > 0 && fin) {
				$('#nothing').remove();
				$("#main_page").append($("<center><h3 id='nothing'>Fin du flux.</h3></center>"));
			} else if(t > 0 && !fin) {
				$('#nothing').remove();
            }
            fetching = false;
	
			updateMasonry();

		}
	});
}



//ajoute une carte à la page
function addCard(c) {
	var idhash= c.idhash;
	var id = c.id;
	var titre = c.titre;
	var dateCreation = c.dateCreation;
	var pseudoUser = c.pseudoUser;
	var idUser = c.idUser;
	var points = c.pointsTotaux;
	var url = c.urlThumbnail;
	var urlSource = c.urlSource;
	var tags = c.tags.split(',');
	var ancien_vote = c.ancien_vote;
	var ancien_report = c.ancien_report;
	var inscription = c.inscription;
	var grade = c.grade;
	var pointsUser = c.pointsUser;
	var posts = c.posts;
	var supprime = c.supprime;
	//string du temps passé depuis le post
	var temps = getTimeElapsed(dateCreation);

	//récupère le template
	var card = $('.template').clone();
	card.attr('id', idhash);
	card.data('id_user', idUser);
	card.find('.card-img>img').attr('src', url);
	card.find('.card-title').html(titre);
	card.find('.card-author>a').html(pseudoUser);
	card.find('.card-time').html(getTimeElapsed(dateCreation, true));
	card.find('.card-link').attr('data-clipboard-text', urlBase + 'view.php?id=' + idhash);


	card.data('tags', c.tags);
    //affiche les tags
	for(var i=0; i < tags.length; ++i) {
		if(i>3)
			break;
		if(tags[i])
			card.find('.tags').append("<a href='index.php?sort="+$('#sort').val()+"&tag="+tags[i]+"'><span class='tag-item'>"+tags[i]+"</span></a>");
	}

    
	card.find('.card-points').html(points);
	
    //upadate l'ancien vote de l'user
	updateVote(card,ancien_vote);
	updateReport(card,ancien_report);

	//assigne les fonctions de vote aux boutons
	card.find(".card-facebook").click(shareFacebook);
	card.find(".card-twitter").click(shareTwitter);
	card.find(".card-gplus").click(shareGplus);


	//bouton SHARE
	card.find(".card-share-plus").click(function(e) {
		animateShare($(this).closest(".card"));
	});

	//bouton THUMBUP
	card.find(".card-thumb-up").click(function(){
		thumbUp(idhash, card);
	});

	//bouton THUMBDOWN
	card.find(".card-thumb-down").click(function() {
		thumbDown(idhash, card);
	});


	card.find('.card-author>a')
		.attr('data-content', "<p>Inscrit il y a "+getTimeElapsed(inscription, false)+"</p><p>Points: "+points+"</p><p><a href='index.php?sort=new&pseudo="+pseudoUser+"'> Posts:</a> "+posts+"</p>").click(function(e){e.stopPropagation();}).popover('fixTitle');

	//bouton OPEN
	card.find(".card-open, .card-img").click(function() {
		var card = $(this).closest(".card, .card-big");
		$(this).tooltip('hide');
		var big = $('.big-card');
		big.attr('id', idhash);
		big.data('card', card);
		big.data('id_user', idUser);
		big.find('.big-card-title').html(titre);
		big.find('.big-card-tmps').html(temps);
		big.find('.big-img-author').html(pseudoUser);
		big.find('.big-card-link').attr('data-clipboard-text', urlBase + 'view.php?id=' + idhash);


		if(idUser == $('#id_user').val() || $("#grade").val() > 0) {
			big.find('.big-card-remove').show();
			big.find('.big-card-signal').hide();
		} else {
			big.find('.big-card-remove').hide();
			big.find('.big-card-signal').show();
		}

		if($('#grade').val() > 0) {
			big.find('.big-card-ban').show();
			big.find('.big-card-sup-def').show();

		} else {
			big.find('.big-card-ban').hide();
			big.find('.big-card-sup-def').hide();
		}

		big.find('.tags').html("");
		tags = card.data('tags').split(',');
		for(var i=0; i < tags.length; ++i) {
			if(tags[i])
				big.find('.tags').append("<a href='index.php?sort="+$('#sort').val()+"&tag="+tags[i]+"'><span class='tag-item'>"+tags[i]+"</span></a>");
		}
		big.find('.tags').append("<span class='glyphicon glyphicon-pencil' title='Modifier les tags' data-toggle='tooltip' id='change_tags'></span>");
		$("[data-toggle='tooltip']").tooltip();

		if(idUser == $('#id_user').val()) {
			$("#change_tags").show();
		} else {
			$("#change_tags").hide();
		}	

		big.data('tags', c.tags);
		big.find('#change_tags').click(function() {
			big.data('tags', card.data('tags'));

			changeTags(big);
		});




		big.find('.big-img-author')
			.attr('data-content', "<p>Inscrit il y a "+getTimeElapsed(inscription, false)+"</p><p>Points: "+points+"</p><p><a href='index.php?sort=new&pseudo="+pseudoUser+"'> Posts:</a> "+posts+"</p>").click(function(e){e.stopPropagation();}).popover('fixTitle')
			.click(function(e){e.stopPropagation();}).popover('fixTitle');



		//update l'ancien vote de l'user
		updateVote(big, card.data('vote'));

		//update l'ancien report
		updateReport(big, card.data('report'));


		big.find('.big-card-points').html(card.find('.card-points').html());
		big.find('.big-card-img').attr('src', urlSource).on('load',
				function() {
					$('.big-card-container').show();
				});

	});

	//HOVER THUMBUP
	card.find(".card-thumb-up").hover(function() {
		$(this).closest(".card").css({
			"-webkit-box-shadow": "0 0 15px 5px #23b9d0",
			"-moz-box-shadow": "0 0 15px 5px #23b9d0",
			"box-shadow": "0 0 15px 5px #23b9d0"
		});
	},
	function() {
		$(this).closest(".card").css({
			"-webkit-box-shadow": "0 0 8px 5px #ccc",
			"-moz-box-shadow": "0 0 8px 5px #ccc",
			"box-shadow": "0 0 8px 5px #ccc"
		});

	});


	//HOVER THUMBDOWN
	card.find(".card-thumb-down").hover(function() {
		$(this).closest(".card").css({
			"-webkit-box-shadow": "0 0 15px 5px #e23d22",
			"-moz-box-shadow": "0 0 15px 5px #e23d22",
			"box-shadow": "0 0 15px 5px #e23d22"
		});
	},
	function() {
		$(this).closest(".card").css({
			"-webkit-box-shadow": "0 0 8px 5px #ccc",
			"-moz-box-shadow": "0 0 8px 5px #ccc",
			"box-shadow": "0 0 8px 5px #ccc"
		});

	});





	$('.card-container').append(card);

	card.addClass('card');
	card.removeClass('template');

	var e = urlSource.split('.').pop();
	if(e == 'gif')
		card.find('.gif-overlay').show();

	//HOVER IMG
	card.mouseenter(function(e) {
		var ext = urlSource.split('.').pop();
		if(ext == 'gif' && !$(this).hasClass("opened")) {
			$(this).addClass("playing");
			$(this).find('.gif-overlay').hide();
			var bigImg = $('<img/>');
			bigImg.attr('src', urlSource);
			bigImg.height(card.find('.card-img>img').height());
			bigImg.on('load', function() {
				card.find('.card-img>img').replaceWith(bigImg);
			});
			e.stopPropagation();
		}
	});

	card.mouseleave(function() {
		var ext = urlSource.split('.').pop();
		if(ext == 'gif' && !$(this).hasClass("opened")) {
			$(this).find('.gif-overlay').show();
			$(this).removeClass('playing');
			var img = $('<img/>');
			img.attr('src', url);
			img.on('load', function() {
				card.find('.card-img>img').replaceWith(img);
			});
		}
	});
	$(card).imagesLoaded().progress(function() {
		updateMasonry();
	});


	//initialise le clipboard lié au bouton copier
	var cb = new Clipboard(card.find(".card-link").get(0));
	cb.on('success', function() {
		//change le titre du tooltip quand on a copié
		card.find('.card-link').attr('title', 'Lien copié !').tooltip('fixTitle').tooltip('show');
	});

	//remet le titre original au hoverOut
	card.find('.card-link').on('mouseout', function() {
		$(this).attr('title', 'Copier le lien').tooltip('fixTitle');
	});

	//initialise les tooltips des boutons de partage
	card.find('[data-toggle="tooltip"]').tooltip();

}









//ouvre/ferme le menu share de la carte
function animateShare(card) {
	var btn = card.find('.card-share-plus');

	if(btn.hasClass('animating')) //déjà en animation
		return;

	var card = btn.closest('.card');

	btn.tooltip('hide');
	btn.addClass('animating');

	if(!btn.hasClass('on')) { //si il n'est pas ouvert, on ouvre

		btn.addClass('on');

		if(currentCardShare != null) //si un autre share menu est ouvert, on le ferme
			animateShare(currentCardShare);
		currentCardShare = card;

		var anim = false;
		card.find('.card-link, .card-open, .card-votes').hide('fade', 150, function() {
			if(!anim) {
				anim = true;
				btn.animate({left: '10px', color: '#e23d22' }, 250, 'easeInOutQuad',
						function() { 
							btn.addClass('red');
							btn.removeClass('animating'); 
						});
				card.find('.card-share-buttons').show('fade', 200);
			}
		});

		btn.css({

			'-moz-animation-name': 'rotateglyph',
			'-moz-animation-duration': '0.15s',
			'-moz-animation-iteration-count': '1',
			'-moz-animation-fill-mode': 'forwards',

			'-webkit-animation-name': 'rotateglyph',
			'-webkit-animation-duration': '0.15s',
			'-webkit-animation-iteration-count': '1',
			'-webkit-animation-fill-mode': 'forwards'

		}).attr('title', 'Retour').tooltip('fixTitle');
	} else { // on ferme

		currentCardShare = null;
		btn.removeClass('on')
			btn.css({
				'-moz-animation-name': 'rotateglyph2',
				'-moz-animation-duration': '0.15s',
				'-moz-animation-iteration-count': '1',
				'-moz-animation-fill-mode': 'forwards',

				'-webkit-animation-name': 'rotateglyph2',
				'-webkit-animation-duration': '0.15s',
				'-webkit-animation-iteration-count': '1',
				'-webkit-animation-fill-mode': 'forwards'

			}).attr('title', 'Partager').tooltip('fixTitle')
		.delay(150).animate({left: '160px', color: 'black'}, 250, 'easeInOutQuad', 
				function() {
					btn.removeClass('red');
					btn.removeAttr('style');	
					btn.removeClass('animating');
				});
		card.find('.card-link, .card-open, .card-votes').delay(200).show('fade', 150);
		card.find('.card-share-buttons').hide('fade', 200);
	}
}

