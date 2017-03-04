<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<?php echo $HEAD ?>
<meta property="og:url"                content=<?php echo "'http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]'" ?> />
<meta property="og:type"               content="article" />
<meta property="og:title"              content=<?php echo "'$titre'" ?> />
<meta property="og:locale"              content="fr_FR" />
<meta property="og:description"        content="Mélenshack, la banque d'images de la France Insoumise !" />
<meta property="og:image"              content=<?php echo "'$urlSource'" ?> />
<meta property="og:image:width"              content=<?php echo "'$width'" ?> />
<meta property="og:image:height"              content=<?php echo "'$height'" ?> />
<meta property="og:app_id"              content="1849815745277262" />
<body>
	<?php echo $NAVBAR ?>

	<div id="main_page" class="container">
		<div class="big-img-container" id=<?php echo "'$id'" ?>>
			<h1 class="big-img-titre"><?php echo $titre ?></h1>

			<!-- header : infos et boutons partage -->
			<div class="big-img-header">
				<div class="big-img-info">
					<span class="points"><?php echo $points ?></span> <img class='phi-points' src='assets/phi.png'/>
					<button type='button' class='btn btn-primary upvote'><span class='glyphicon glyphicon-arrow-up'></span></button>
					<button type='button' class='btn btn-danger downvote'><span class='glyphicon glyphicon-arrow-down'></span></button>
					<br><div class='temps'>
						Il y a <?php echo "$temps par <a href='user.php?id=$idUser'>$pseudoUser</a>" ?>
						</div>

					<div class="big-share-group">
						<img data-toggle='tooltip' title='Partager' src="assets/Facebook.png" class="big-share" id="share_fb"/>
						<img data-toggle='tooltip' title='Partager' src="assets/Twitter.png" class="big-share" id="share_twitter"/>
						<img data-clipboard-text=<?php echo "'http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]'" ?> data-toggle='tooltip' title='Copier le lien' src="assets/Clipboard.png" class="big-share" id="share_clipboard"/>
					</div>		
				</div>
			</div>

			<center><img class="big-img" src=<?php echo "'$urlSource'" ?> /></center>
		</div>
	</div>
</body>
</html>
