<!DOCTYPE html>
<html lang="fr">
<?php echo $HEAD ?>

<body>
	<?php echo $NAVBAR ?>


	<!-- container principal -->

	<div id='main_page'>

	<div class="big-card-container" hidden>
	<div class="big-card-overlay">
		<div class="big-card">
				
			<div class="big-card-share">
				<?php if(!$showSupprime): ?>
				<span data-placement='bottom' data-toggle="tooltip" title="Signaler" class="big-card-signal glyphicon glyphicon-warning-sign"></span>
				<span data-placement='bottom' data-toggle="tooltip" title="Supprimer" class="big-card-remove glyphicon glyphicon-trash"></span>
				<?php else: ?>

					<?php if($sort == "deleted"): ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Restaurer" class="big-card-remove glyphicon glyphicon-trash voted"></span>
					<?php else: ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Supprimer" class="big-card-remove glyphicon glyphicon-trash"></span>
					<?php endif ?>
				
				<?php endif ?>
				<img data-placement='bottom' data-toggle="tooltip" title="Facebook" class="big-card-facebook" src="assets/Facebook.png"/>
				<img data-placement='bottom' data-toggle="tooltip" title="Twitter" class="big-card-twitter" src="assets/Twitter.png"/>
				<img data-placement='bottom' data-toggle="tooltip" title="Google Plus" class="big-card-gplus" src="assets/Google_plus.png"/>

				<span data-placement='bottom' data-toggle="tooltip" title="Fermer" class="big-card-close glyphicon glyphicon-remove"></span>
			</div>

			<div class="big-card-title">
				Mélenshack, ce site de génie, waow
			</div>
			<div class="big-card-infos">
			Il y a <span class="big-card-tmps">3 heures</span> par <a data-toggle='popover' data-html="true" class="big-img-author" href='#'>Entropy</a>
			</div>

			<div class="big-card-votes">
				<span data-toggle="tooltip" title="J'aime" class="glyphicon glyphicon-thumbs-up card-thumb-up" ></span>
		   
				<span data-toggle="tooltip" title="J'aime pas" class="glyphicon glyphicon-thumbs-down card-thumb-down" ></span>
			</div>
			<div class="big-card-points">352</div>
			<div class="big-card-img">
				<img class='big-card-img' src="http://www.personalcreations.com/blog/wp-content/uploads/2014/09/how-long-to-read.png" />
			</div>
		</div>
	</div>
	</div>
	<div class="card-container">
		<input id='sort' value=<?php echo "'$sort'" ?> hidden/>
	
		<div class="template">
			<div class="card-img">
				<img />
			</div>

			<div class="card-title">
			</div>
	
			<div class="card-author">
				<a data-toggle='popover' data-html="true" href="#"></a>
			</div>

			<div class="card-footer">
				<div class="card-share">
			
					<span data-toggle="tooltip" title="Copier le lien" class="glyphicon glyphicon-link card-link" ></span>
					<span data-toggle="tooltip" title="Agrandir" class="glyphicon glyphicon-fullscreen card-open" ></span>
					<span data-toggle="tooltip" title="Partager" class="glyphicon glyphicon-share-alt card-share-plus" ></span>
				</div>
				<div class="card-votes">
					<span data-toggle="tooltip" title="J'aime" class="glyphicon glyphicon-thumbs-up card-thumb-up" ></span>
			   
					<span data-toggle="tooltip" title="J'aime pas" class="glyphicon glyphicon-thumbs-down card-thumb-down" ></span>
				</div>
			<div hidden class="card-share-buttons">
				<img data-toggle="tooltip" title="Facebook" class="card-facebook" src="assets/Facebook.png"/>
				<img data-toggle="tooltip" title="Twitter" class="card-twitter" src="assets/Twitter.png"/>
				<img data-toggle="tooltip" title="Google Plus" class="card-gplus" src="assets/Google_plus.png"/>

			</div>
	</div>


</div>

</div>

</div>
</body>
</html>
