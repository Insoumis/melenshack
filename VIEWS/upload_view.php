<!DOCTYPE html>
<html lang="fr">
	<?php echo $HEAD ?>
	<body>
		<?php echo $NAVBAR ?>
		<div class="container" id="main_page">

			<?php if(!empty($errmsg)): ?>
			<div class='alert alert-danger erreur'>
				<a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
				<?php echo $errmsg ?>
			</div>
			<?php endif ?>
			<?php if($showPage): ?>

			<form class="upload" action="MODELS/upload_conf.php" autocomplete="off" method="post" enctype="multipart/form-data">
				<h1>Ajouter une image</h1>
				<div class="form-group col-xs-5">
					<label for="titre">Titre de l'image:</label>
					<input type="text" class="form-control input-lg" name="titre" id="titre" placeholder="Titre de votre post" required autofocus>

					<p id="formats"><small>Formats acceptés: JPG, PNG, GIF. Poids max: <?php echo $maxsize/1000000 ?> Mo</small></p>
					<label for="file" id="drop">
						<div>
							<p>
							<label for="file" id="filelabel">	
								<strong><span class="glyphicon glyphicon-folder-open"></span>Choisissez une image</strong>													<input id="file" name="file" type="file" style="display: none;">
							</label> ou glissez la ici</p>

							<div id="nameContainer" hidden>
								<p><span class="glyphicon glyphicon-ok"></span><span id="name"></span></p>
							</div>
							<div id="errorContainer" hidden>
								<p><span class="glyphicon glyphicon-remove"></span><span id="error"></span></p>
							</div>
						</div>
					</label>

					<div id="urlgroup" class="form-group form-inline">
						<label for="url" id="urltext">ou entrez l'URL de l'image:</label>
						<input type="url" id="url" name="url" class="form-control"/>
					</div>

					<div class="tags">
						<label for="tagsinput"><span class="glyphicon glyphicon-tags"></span>Tags (séparés par des virgules): </label>
						<br>
						<select multiple name="tags[]" id="tagsinput" type="text" data-role="tagsinput"></select>
					</div>
					<div class="g-recaptcha" data-sitekey="6LeKlhgUAAAAAAaxaZrJdqgzv57fCkNmX5UcXrwG" data-callback="recaptchaCallback"></div>
					<br>
					<input type="hidden" name="token" id="token" value="<?php echo $token_upload?>">
					<input type="submit" id="submit" class="btn btn-primary btn-lg" name="submit" value="Poster l'image" accept="image/*" required disabled>
				</div>
				<input type="hidden" id="max" name="taille_max" value=<?php echo "'$maxsize'" ?> />
			<small>Merci de faire attention à la provenance de vos images ! Préférez les images libres de droit, issues du site officiel ou créées par vous.</small>
			</form>

			<?php endif ?>
		</div>
	</body>
</html>
