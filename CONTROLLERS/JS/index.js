
var currentCardShare;
var gridLayout;

$(document).ready(function() {
	gridLayout = $('.card-container');
	//layout
	gridLayout.masonry({
		itemSelector: '.card',
		columnWidth: 370,
		fitWidth: true,
		stagger: 30
	});

	$('#searchinput').on('change paste keyup', function() {
		$('.card').each(function(i, card) {
			if(!($(card).find('.card-title').html()).includes($('#searchinput').val()))
				card.remove();
		});
		currentIndex = 0;
		getCards(30);
		$(gridLayout).masonry('reloadItems');
		$(gridLayout).masonry('layout');
	});

	/*
	   initialise la big-card

	 */

	$('.big-card-remove').hide();
	//ferme la bigimg si on clique à coté
	$('.big-card-container').click(function() {	
		$('.big-card-container').hide();
		checkVote($('.big-card').data('card'));
	});
	$('.big-card').click(function(e) {
		e.stopPropagation();
	});

	//ferme la bigimg si on clique sur la croix
	$('.big-card-close').click(function() {
		$('.big-card-container').hide();
		checkVote($('.big-card').data('card'));
	});

	//signalement
	$('.big-card-signal').click(function() {
		if($('#connected').val() == 'no') {
			showVoteError();
			return;
		}
		if($(this).hasClass('voted'))
			return;

		var conf = false;
		conf = confirm('Voulez-vous vraiment signaler ce post ?');
		if(!conf)
			return;

		//send report to server
		$.post(
				'MODELS/report_conf.php',
				{
					idhash: $('.big-card').attr('id'),
				},
				function(e) {
					$('.big-card-signal').addClass('voted').attr('title', 'Signalé').tooltip('fixTitle').tooltip('show');
				},
				'text'
			  );


	});

	$('.big-card-remove').click(function() {
		var conf = false;	
		var value = 1;
		if($(this).hasClass("voted")) {
			conf = confirm("Voulez-vous vraiment restaurer ce post ?");
			value = 0;
		} else {
			conf = confirm("Voulez-vous vraiment supprimer ce post ?");
		}
		if(!conf)
			return;

		//send remove to server
		$.post(
				'MODELS/supprime_conf.php',
				{
					idhash: $('.big-card').attr('id'),
					value: value
				},
				function(e) {
					$('.big-card-container').hide();
					$('.card').each(function(i, card) {
						if($(card).attr('id') == $('.big-card').attr('id'))
							$(card).remove();
						$(gridLayout).masonry('reloadItems');
						$(gridLayout).masonry('layout');
					});
				},
				'text'
			  );

	});

	//partages réseaux sociaux
	$('.big-card-facebook').click(shareFacebook);
	$('.big-card-twitter').click(shareTwitter);
	$('.big-card-gplus').click(shareGplus);

	//initalise les tooltips
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();

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
	getCards(30);

});


//quand l'user atteind le bas de la page, rajoute 20 cartes
$(window).scroll(function() {
	getCards(20);
});


//nb de cartes affichées
var currentIndex = 0;

//récupère les $size prochaines cartes depuis le serveur et les affiche
function getCards(size) {
	var sort = $('#sort').val();
	var search = $('#searchinput').val();

	$.ajax({
		url: 'MODELS/requestajax.php',
		type: 'POST',
		data: {
			'size': size,
			'sort': sort,
			'startIndex': currentIndex,
			'search': search
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
			currentIndex += i;
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
	//string du temps passé depuis le post
	var temps = getTimeElapsed(dateCreation);

	//récupère le template
	var card = $('.template').clone();
	card.attr('id', idhash);
	card.find('.card-img>img').attr('src', url);
	card.find('.card-title').html(titre);
	card.find('.card-author>a').html(pseudoUser);
	card.find('.card-time').html(getTimeElapsed(dateCreation, true));
	card.find('.card-link').attr('data-clipboard-text', urlBase + 'view.php?id=' + idhash);

	for(var i=0; i < tags.length; ++i) {
		if(i>5)
			break;
		card.find('.tags').append("<span class='tag-item'>"+tags[i]+"</span>");
	}

	card.find('.card-points').html(points);
	//vérifie l'ancien vote de l'user
	checkVote(card);

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
	
	$.post(
			'MODELS/usersinfo.php',
			{id: idUser},
			function(data) {
				data = JSON.parse(data);

				card.find('.card-author>a')
					//.attr('title', '<strong>'+data.pseudo+'</strong>')
					.attr('data-content', "<p>Inscrit il y a "+getTimeElapsed(data.inscription, false)+"</p><p>Points: "+data.points+"</p><p>Posts: "+data.posts+"</p>")
					.click(function(e){e.stopPropagation();}).popover();
			},
			'text'
		);
	
	
	//bouton OPEN
	card.find(".card-open").click(function() {
		var card = $(this).closest(".card, .card-big");
		$(this).tooltip('hide');
		var big = $('.big-card');
		big.attr('id', idhash);
		big.data('card', card);
		big.find('.big-card-title').html(titre);
		big.find('.big-card-tmps').html(temps);
		big.find('.big-img-author').html(pseudoUser);
		if(idUser == $('#id_user').val()) {
			big.find('.big-card-remove').show();
			big.find('.big-card-signal').hide();
		}
		
		$.post(
			'MODELS/usersinfo.php',
			{id: idUser},
			function(data) {
				data = JSON.parse(data);

				big.find('.big-img-author')
					.attr('title', '<strong>'+data.pseudo+'</strong>')
					.attr('data-content', "<p>Inscrit il y a "+getTimeElapsed(data.inscription, false)+"</p><p>Points: "+data.points+"</p><p>Posts: "+data.posts+"</p>")
					.click(function(e){e.stopPropagation();}).popover('fixTitle');
			},
			'text'
		);
		

		//vérifie l'ancien vote de l'user
		checkVote(big);

		//vérifier l'ancien report
		$.post(
				'MODELS/check_report.php',
				{idhash: idhash},
				returnReport,
				'text'
			  );

		function returnReport(ancien) {
			ancien = parseInt(ancien);
			if(ancien == 1) {
				$('.big-card-signal').addClass('voted').attr('title', 'Signalé').tooltip('fixTitle');
			} else {
				$('.big-card-signal').removeClass('voted').attr('title', 'Signaler').tooltip('fixTitle');

			}
		}

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

	//HOVER IMG
	card.mouseenter(function(e) {
		var ext = urlSource.split('.').pop();
		if(ext == 'gif' && !$(this).hasClass("opened")) {
			$(this).addClass("playing");
			var bigImg = $('<img/>');
			bigImg.attr('src', urlSource);
			bigImg.addClass('card-img');
			bigImg.on('load', function() {
				card.find('.card-img').replaceWith(bigImg);
			});
			e.stopPropagation();
		}
	});

	card.mouseleave(function() {
		var ext = urlSource.split('.').pop();
		if(ext == 'gif' && !$(this).hasClass("opened")) {
			$(this).removeClass('playing');
			var img = $('<img/>');
			img.attr('src', url);
			img.addClass('card-img');
			img.on('load', function() {
				card.find('.card-img').replaceWith(img);
			});
		}
	});
	$(card).imagesLoaded().progress(function() {
		$(gridLayout).masonry('reloadItems');
		$(gridLayout).masonry('layout');
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

