<!DOCTYPE html>

<html lang="fr">
<?php include 'includes/header.php'; ?>


<div class="container" id="main_page">
	<h1>Ajouter une image</h1>
	<p class="lead">Selectionnez une image à poster</p>
	<form action="upload.php" autocomplete="off" method="post" enctype="multipart/form-data">
	<div class="form-group col-xs-5">
	<label for="titre"><h3>Titre de l'image:</h3></label>
	<input type="text" class="form-control input-lg" name="titre" id="titre" required autofocus>
	<br>
	
	<label class="btn btn-default btn-file">
	    Parcourir<input id="file" name="file" type="file" style="display: none;">
	</label>
	<label for="file">Veuillez selectionner une image JPG, PNG ou GIF</label>
	<br>
	<img id="preview" />
	<br>

	<input type="submit" id="submit" class="btn btn-primary btn-lg disabled" name="submit" value="Poster l'image" accept="image/*" required>
	</div>
	<input type="hidden" id="max" name="taille_max" value="10000000" />
	</form>

	
</div>

<script>
function readURL(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			if(input.files[0].size > $("#max").val()) {
				alert("Fichier trop lourd !");
				return;
			}
			$("#preview").attr("src", e.target.result).width(800);
			$("#submit").removeClass("disabled");
		}

		reader.readAsDataURL(input.files[0]);
	} else {
		$("#submit").addClass("disabled");
	}
}

$("#file").change(function() {
	readURL(this);
});

</script>
</body>
</html>
