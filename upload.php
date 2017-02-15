<!DOCTYPE html>
<html lang="fr">
<?php include 'includes/header.php';?>
<script src='https://www.google.com/recaptcha/api.js'></script>


<div class="container" id="main_page">

<?php
if (!empty($_GET['erreur'])) {
	$erreur = $_GET['erreur'];
	if ($erreur) {
		if ($erreur == "notlogged")
			$msg = "Vous devez être connecté pour poster une image ! <a href='login.php'>Se connecter.</a>";
		else if ($erreur == "captcha")
			$msg = "Captcha invalide ! Veuillez réessayer.";
		else if ($erreur == "size")
			$msg = "Image trop lourde !";
		else if ($erreur == "format")
			$msg = "L'image doit être en format PNG, JPG, JPEG ou GIF !";
		else if ($erreur == "titre")
			$msg = "Titre trop long !";
		else
			$msg = "Veuillez réessayer";

		echo "<div class='alert alert-danger erreur'>
	  <strong>Erreur !</strong> $msg
	  </div>";
	}
} else if (!isset($_SESSION['id'])) {

	echo "<div class='alert alert-danger erreur'>
	  Vous devez être connecté pour pouvoir poster une image ! <a href='login.php'>Se connecter</a>.
	  </div>";
	exit();
}
?>
		<h1>Ajouter une image</h1>
		<p class="lead">Selectionnez une image à poster</p>
		<form action="upload_conf.php" autocomplete="off" method="post" enctype="multipart/form-data">
			<div class="form-group col-xs-5">
				<label for="titre"><h3>Titre de l'image:</h3></label>
				<input type="text" class="form-control input-lg" name="titre" id="titre" placeholder="Titre (recommendé < 20 caractères)" required autofocus>
				<br>
				<label class="btn btn-default btn-file">
				    Parcourir<input id="file" name="file" type="file" style="display: none;">
				</label>
				<label for="file">Veuillez selectionner une image JPG, PNG ou GIF</label>
				<br>
				<img id="preview" />
				<br>
				<div class="g-recaptcha" data-sitekey="6LefaBUUAAAAALVKIo2DiW_hWLs2kijFTrlUHGMb" data-callback="recaptchaCallback"></div>
				<br>
				<input type="submit" id="submit" class="btn btn-primary btn-lg" name="submit" value="Poster l'image" accept="image/*" required disabled>
			</div>
			<input type="hidden" id="max" name="taille_max" value="10000000" />
		</form>
	</div>
<script>

var captchaChecked = false;
var image = false;

function recaptchaCallback() {
	captchaChecked = true;
	checkSubmit();
}

function readURL(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			if(input.files[0].size > $("#max").val()) {
				alert("Fichier trop lourd !");
				return;
			}
			$("#preview").attr("src", e.target.result).width(800);
			image = true;
			checkSubmit();
		}

		reader.readAsDataURL(input.files[0]);
	} else {
		image = false;
	}
}

$("#file").change(function() {
	readURL(this);
});

$("#titre").on('input', function() {
	checkSubmit();
});

function checkSubmit() {
	if(image && captchaChecked && $("#titre").val()) {
		$("#submit").prop("disabled", false);	
	}
}

</script>
</body>
</html>
