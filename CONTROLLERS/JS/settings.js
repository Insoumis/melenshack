$(window).on('load', function() {

	$('#delete').click(function() {
		var conf = false;
		conf = confirm("/!\\ ATTENTION ! \nVoulez-vous vraiment suprimer votre compte ? \nToutes vos informations et vos images postées seront supprimées de la base de donnée.");
		if(!conf)
			return;
		window.location.href = "MODELS/supprime_compte.php?token="+$("#token").html();
	
	});
});
