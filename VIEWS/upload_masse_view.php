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

			<form class="upload" action="MODELS/upload_masse_conf.php" autocomplete="off" method="post" enctype="multipart/form-data">
				<h1>Ajouter des images</h1>
				<div class="form-group col-xs-5">
					<label for="titre">Titre des images (optionnel) :</label>
					<input type="text" class="form-control input-lg" name="titre" id="titre" placeholder="Titre de votre post" autofocus>

					<p id="formats"><small>Formats acceptés: JPG, PNG, GIF. Poids max: 100 Mo pour l'ensemble des images</small></p>
					<label for="file" id="drop">
							<p>
							<label for="file" id="filelabel">	
								<strong><span class="glyphicon glyphicon-folder-open"></span>Choisissez des images</strong>													<input id="file" name="file[]" type="file" style="display: none;" multiple>
							</label> ou glissez les ici</p>

							<div id="nameContainer" hidden>
								<p><span id="name"></span></p>
							</div>
							<div id="errorContainer" hidden>
								<p><span class="glyphicon glyphicon-remove"></span><span id="error"></span></p>
							</div>
					</label>

					<div id="urlgroup" class="form-group form-inline">
						<label for="url" id="urltext">ou entrez les URLs des images:<br>(une par ligne)</label>
						<textarea wrap="off" id="url" name="url" class="form-control"></textarea>
					</div>

					<div class="tags">
						<label for="tagsinput"><span class="glyphicon glyphicon-tags"></span>Tags (séparés par des virgules) (optionnel):</label>
						<br>
						<select multiple name="tags[]" id="tagsinput" type="text" data-role="tagsinput"></select>
					</div>
					<?php if($showPseudo): ?>
						<br><label for="pseudo">Pseudo du créateur (optionnel): </label>
						<input type="text" id="pseudo" name="pseudo" class="form-control"/>

					<?php endif ?>

					<br>
					<input type="hidden" name="token" id="token" value="<?php echo $token_upload?>">
					<input type="submit" id="submit" class="btn btn-primary btn-lg" name="submit" value="Poster l'image" accept="image/*" required>
				</div>
				<input type="hidden" id="max" name="taille_max" value=<?php echo "'$maxsize'" ?> />
			<small>Merci de faire attention à la provenance de vos images ! Préférez les images libres de droit, issues du site officiel ou créées par vous.</small>
			</form>
			<?php endif ?>
		</div>
	</body>
</html>
