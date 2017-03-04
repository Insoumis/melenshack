//A FAIRE : FUSIONNER CE SCRIPT AVEC COMMON CARDS

//id de l'image
var idhash = $('.big-img-container').attr('id');


$(window).on('load', function() {
	//vérifie l'ancien vote
	checkVote($('.big-img-container'));

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
	
	$.post(
			'MODELS/usersinfo.php',
			{id: $('#idUser').val()},
			function(data) {
				data = JSON.parse(data);

				$('.temps>a')
					//.attr('title', '<strong>'+data.pseudo+'</strong>')
					.attr('data-content', "<p>Inscrit il y a "+getTimeElapsed(data.inscription, false)+"</p><p>Points: "+data.points+"</p><p><a href='index.php?sort=new&pseudo="+data.pseudo+"'> Posts:</a> "+data.posts+"</p>")
					.click(function(e){e.stopPropagation();}).popover();
			},
			'text'
		  );

	//initialise les tooltips des boutons de partage
	$("[data-toggle='tooltip']").tooltip();
	$("[data-toggle='popover']").popover();
	

});

