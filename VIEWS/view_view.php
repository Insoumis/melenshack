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
	
	<input id="dateCreation" value=<?php echo "'$dateCreation'" ?> hidden>
	<input id="idUser" value=<?php echo "'$idUser'" ?> hidden>
	<div id="main_page" class="container">
		<div class="big-img-container" id=<?php echo "'$idhash'" ?>>
			<!-- header : infos et boutons partage -->
			<div class="big-img-header">
			<div class="big-img-titre"><?php echo $titre ?></div>
			<div class='temps'>
				<span class="glyphicon glyphicon-time"></span> <span class="elapsed"></span><?php echo " par <a data-toggle='popover' data-html='true'>$pseudoUser</a>" ?>
			</div>
			<div class="tags">
			<?php 
			foreach($tags as $tag) {
				if($tag)
					echo "<a href='index.php?sort=$sort&tag=$tag'><span class='tag-item'>$tag</span></a>";
			
			}
			echo "<input type='text' id='tagsstr' value='$tagsstr' hidden>";

			?>
			</div>
				<div class="big-img-info">
					<div class="votes">
						<span data-toggle="tooltip" title="J'aime" class="glyphicon glyphicon-thumbs-up card-thumb-up" ></span>

						<span data-toggle="tooltip" title="J'aime pas" class="glyphicon glyphicon-thumbs-down card-thumb-down" ></span>
					</div>
					<div class="points"><?php echo $points ?>  </div>

					<div class="big-share-group">

				<img data-placement='top' data-toggle="tooltip" title="Facebook" class="big-img-facebook" src="assets/Facebook.png"/>
				<img data-placement='top' data-toggle="tooltip" title="Twitter" class="big-img-twitter" src="assets/Twitter.png"/>
				<img data-placement='top' data-toggle="tooltip" title="Google Plus" class="big-img-gplus" src="assets/Google_plus.png"/>
					</div>		
				</div>
			</div>
			<br>
			<center><img class="big-img" src=<?php echo "'$urlSource'" ?> /></center>
		</div>
	</div>
</body>
</html>
