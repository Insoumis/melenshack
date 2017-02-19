<!DOCTYPE html>
<html lang="fr">
<?php echo $HEAD ?>

<body>
	<?php echo $NAVBAR ?>


	<!-- container principal -->
	<div class="card-container" id="main_page">
		<input id='sort' value=<?php echo "'$sort'" ?> hidden/>
	
		<div class="template">
			<div class="card-img">
				<img />
			</div>

			<div class="card-title">
			</div>
	
			<div class="card-author">
				<a href="#"></a>
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


</body>
</html>
