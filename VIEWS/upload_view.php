<!DOCTYPE html>
<html lang="fr">
<?php echo $HEAD ?>
<body>
	<?php echo $NAVBAR ?>
	<div class="container" id="main_page">

		<?php if(!empty($errmsg)): ?>
			<div class='alert alert-danger erreur'>
				<?php echo $errmsg ?>
			</div>
		<?php endif ?>
		<?php if($showPage): ?>

			<h1>Ajouter une image</h1>
			<p class="lead">Selectionnez une image à poster</p>
			<form action="MODELS/upload_conf.php" autocomplete="off" method="post" enctype="multipart/form-data">
				<div class="form-group col-xs-5">
					<label for="titre"><h3>Titre de l'image:</h3></label>
					<input type="text" class="form-control input-lg" name="titre" id="titre" placeholder="Titre (recommendé < 20 caractères)" required autofocus>
					<br>
					<label class="btn btn-default btn-file">
					    Parcourir<input id="file" name="file" type="file" style="display: none;">
					</label>
					<label for="file">Veuillez selectionner une image JPG ou PNG</label>
					<br>
					OU
					<input type="url" name="url" id="url" class="form-control input-md">
					<label for="url">Veuillez entrer l'URL de l'image (JPG, PNG, BMP ou GIF)</label>
					<img id="preview" />
					<label for="file">Si après avoir uploadé l'image ou après avoir mit l'url, l'image ne s'affiche pas, c'est qu'elle n'est pas valide.</label>
					<br>
					<div class="g-recaptcha" data-sitekey="6LefaBUUAAAAALVKIo2DiW_hWLs2kijFTrlUHGMb" data-callback="recaptchaCallback"></div>
					<br>
					<input type="submit" id="submit" class="btn btn-primary btn-lg" name="submit" value="Poster l'image" accept="image/*" required disabled>
				</div>
				<input type="hidden" id="max" name="taille_max" value=<?php echo "'$maxsize'" ?> />
			</form>

		<?php endif ?>
	</div>
</body>
</html>
