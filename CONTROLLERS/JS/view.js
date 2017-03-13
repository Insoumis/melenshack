
//id de l'image
var idhash = $('.big-img-container').attr('id');

$("[data-toggle='tooltip']").tooltip();

$(document).click(function() {
		$('#main_page .popover').popover('hide');
		});
$(window).on('load', function() {


		$('.big-img-container').data('tags', $('#tagsstr').val());

		//initialise le clipboard
		$('.big-img-link').attr('data-clipboard-text', urlBase + 'view.php?id=' + idhash);

		var c = new Clipboard($(".big-img-link").get(0));
		c.on('success', function() {
				//change le titre du tooltip quand on a copié
				$('.big-img-link').attr('title', 'Lien copié !').tooltip('fixTitle').tooltip('show');
				});

		//remet le titre original au hoverOut
		$('.big-card-link').on('mouseout', function() {
				$(this).attr('title', 'Copier le lien').tooltip('fixTitle');
				});

		$('.big-img-facebook').click(shareFacebook);
		$('.big-img-twitter').click(shareTwitter);
		$('.big-img-gplus').click(shareGplus);

		$('.big-img-container').find(".card-thumb-up").click(function() {
				thumbUp(idhash, $('.big-img-container'));
				});

		$('.big-img-container').find(".card-thumb-down").click(function() {
				thumbDown(idhash, $('.big-img-container'));
				});
		$('.elapsed').html(getTimeElapsed($('#dateCreation').val()));

		$('.temps>a')
			.attr('data-content', "<p>Inscrit il y a "+getTimeElapsed($('#inscription').val(), false)+"</p><p>Points: "+$('#pointsUser').val()+"</p><p><a href='index.php?sort=new&pseudo="+$('#pseudo').val()+"'> Posts:</a> "+$('#posts').val()+"</p>")
			.click(function(e){e.stopPropagation();}).popover();

		$("[data-toggle='tooltip']").tooltip();


		$('.big-card-signal').click(function() {
				report($('.big-img-container'));
				});
		
		$('.big-card-edit').click(function() {
			if(!$('.big-img-container').hasClass('editing'))
				startEdit($('.big-img-container'));
			else
				validateEdit($('.big-img-container'));
		});

		//suppression
		$('.big-card-remove').click(function() {
				if(supprime_restore($('.big-img-container')) != -1)
					window.location.href = 'index.php';
				});

		//ban + suppression
		$('.big-card-ban').click(function() {
				if(ban_sup($('.big-img-container'), $('#idUser').val()) != -1)
					window.location.href = 'index.php';
				});


		//initialise les tooltips des boutons de partage
		$("[data-toggle='tooltip']").tooltip();
		$("[data-toggle='popover']").popover();


});

