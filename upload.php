<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>MELUCHE <3</title>
	<meta name="description" content="La banque d'images de la France Insoumise">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<link rel="stylesheet" href="style.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous" defer async></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>

<?php include 'includes/header.php'; 
if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])) {
?>

<div class="container" id="main_page">
	<h1>Ajouter une image</h1>
	<p class="lead">Selectionnez une image à poster</p>
	<form action="upload_conf.php" method="post" enctype="multipart/form-data">
		<div class="form-group col-xs-5">
			<label for="titre"><h3>Titre de l'image:</h3></label>
			<input type="text" class="form-control input-lg" name="titre" id="titre" required>
			<br>
			
			<label class="btn btn-default btn-file">
				Parcourir<input id="file" name="file" type="file" style="display: none;">
			</label>
			<label for="file">Veuiller selectionner une image</label>
			<br>
			<img id="preview" />
			<br>
			<br><br><br>
			<input type="submit" id="submit" class="btn btn-primary btn-lg disabled" name="submit" value="Poster l'image" accept="image/*" required>
		</div>
		<input type="hidden" id="max" name="taille_max" value="1000000" />
	</form>
</div>
<?php } else { ?>
<div class="container" id="main_page">
		<p>Vous n'êtes pas connecter !</p>
		Voulez-vous <a href="login.php">vous connecter</a> ou <a href="register.php">vous inscrire</a> ?
</div>
<?php } ?>

<script>
function readURL(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			if(input.files[0].size > $("#max").val()) {
				alert("Fichier trop lourd !");
				return;
			}
			$("#preview").attr("src", e.target.result).width(600);
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
