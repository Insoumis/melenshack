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


	$('.tags').append("<span class='glyphicon glyphicon-pencil' title='Modifier les tags' data-toggle='tooltip' id='change_tags'></span>");
	$("[data-toggle='tooltip']").tooltip();

	if($("#idUser").val() == $('#id_user').val()) {
		$("#change_tags").show();
	} else {
		$("#change_tags").hide();
	}

	var change = function() {
		$('.tags').html("");
		var str;
		if(!$('#tagsstr').val())
			str = "";
		else
			str = $('#tagsstr').val();
		$('.tags').append("<input id='tagsinput' type='text' data-role='tagsinput' placeholder='+ tags' value='"+str+"'/><span class='glyphicon glyphicon-ok' id='change_tags_ok' title='Appliquer les tags' data-toggle='tooltip'></span>");
		$('#tagsinput').tagsinput({
			maxTags: 10,
			maxChars: 20,
			trimValue: true
		});
		$("[data-toggle='tooltip']").tooltip();

		$('#change_tags_ok').click(function() {

			$.post("MODELS/change_tags.php", {tags: $('#tagsinput').val(), id: $(".big-img-container").attr('id')});
			var tags = $('#tagsinput').val().split(",");
			$('#tagsstr').val($('#tagsinput').val());
			$('.tags').html("");
			for(var i=0; i < tags.length; ++i) {
				if(tags[i])
					$('.tags').append("<a href='index.php?sort="+$('#sort').val()+"&tag="+tags[i]+"'><span class='tag-item'>"+tags[i]+"</span></a>");
			}
			$(".tags").append("<span class='glyphicon glyphicon-pencil' title='Modifier les tags' data-toggle='tooltip' id='change_tags'></span>");
			$("[data-toggle='tooltip']").tooltip();
			$('#change_tags').click(change);

		});
	}

	$('#change_tags').click(change);
	//initialise les tooltips des boutons de partage
	$("[data-toggle='tooltip']").tooltip();
	$("[data-toggle='popover']").popover();


});

