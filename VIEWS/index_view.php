<!DOCTYPE html>
<html lang="fr">
<?php echo $HEAD ?>

<body>
	<?php echo $NAVBAR ?>

	<input id='search_pseudo' value=<?php echo "'$search_pseudo'"; ?> hidden>
	<input id='search_tag' value=<?php echo "'$search_tags'"; ?> hidden>


	<!-- container principal -->

	<div id='main_page'>

	<div class="big-card-container" hidden>
	<div class="big-card-overlay">
		<div class="big-card">
				
				<?php if(!$showSupprime): ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Signaler" class="big-card-signal glyphicon glyphicon-warning-sign"></span>
					<span data-placement='bottom' data-toggle="tooltip" title="Supprimer" class="big-card-remove glyphicon glyphicon-trash"></span>
				<?php else: ?>

				<?php if($sort == "deleted"): ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Restaurer" class="big-card-remove glyphicon glyphicon-trash voted"></span>
					<span data-placement='bottom' data-toggle="tooltip" title="Supprimer définitivement" class="big-card-sup-def glyphicon glyphicon-erase"></span>
					<?php else: ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Supprimer" class="big-card-remove glyphicon glyphicon-trash"></span>
					<span data-placement='bottom' data-toggle="tooltip" title="Supprimer et bannir" class="big-card-ban glyphicon glyphicon-ban-circle"></span>
					<?php endif ?>
				
				<?php endif ?>
				
				<div class="big-card-infos">
					<span class="glyphicon glyphicon-time"></span> <span class="big-card-tmps"></span> par <strong><a data-placement='bottom' data-toggle='popover' data-html="true" class="big-img-author" href='#'></a></strong>
				</div>
				<span data-placement='bottom' data-toggle="tooltip" title="Fermer" class="big-card-close glyphicon glyphicon-remove"></span>

			
			<div class="big-card-title">
			</div>
			
			<div class="big-card-align">

			<div class="big-card-share">
				<img data-toggle="tooltip" title="Facebook" class="big-card-facebook" src="assets/Facebook.png"/>
				<img data-toggle="tooltip" title="Twitter" class="big-card-twitter" src="assets/Twitter.png"/>
				<img data-toggle="tooltip" title="Google Plus" class="big-card-gplus" src="assets/Google_plus.png"/>
				<span data-toggle="tooltip" title="Copier le lien" class="glyphicon glyphicon-link big-card-link" ></span>
			</div>

			
			<div class="big-card-votes">
		   
				<span data-toggle="tooltip" title="J'aime pas" class="glyphicon glyphicon-thumbs-down card-thumb-down" ></span>
				<span data-toggle="tooltip" title="J'aime" class="glyphicon glyphicon-thumbs-up card-thumb-up" ></span>
			</div>
			<div class="big-card-points">352</div>

			<br>
			<div class="big-card-img">
				<img class='big-card-img' src="" />
			</div>
			</div>
			<div class="tags"></div>
		</div>
	</div>
	</div>
	<div class="card-container">
		<input id='sort' value=<?php echo "'$sort'" ?> hidden/>
	
		<div class="template">
			<div class="card-img" title="Agrandir">
				<div class="gif-overlay" hidden><img src="assets/gif_overlay.png"/></div>
				<img />
			</div>

			<div class="card-title">
			</div>
	
			<div class="card-author">
				<a data-toggle='popover' data-html="true"></a>
			</div>
			<div class="card-time-container">	
				<span class="card-time"></span>
				<span class="glyphicon glyphicon-time"></span>
			</div>
			<br>
			<div class="tags">
			</div>
			<div class="card-footer">
				<div class="card-share">
			
					<span data-toggle="tooltip" title="Copier le lien" class="glyphicon glyphicon-link card-link" ></span>
					<span data-toggle="tooltip" title="Agrandir" class="glyphicon glyphicon-fullscreen card-open" ></span>
					<span data-toggle="tooltip" title="Partager" class="glyphicon glyphicon-share-alt card-share-plus" ></span>
				</div>
				<div class="card-votes">
					<div class="card-points"></div>
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
