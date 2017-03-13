<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<?php require 'head.php' ?>

<body>
	<?php echo $NAVBAR ?>

	<input id="dateCreation" value=<?php echo "'$dateCreation'" ?> hidden>
	<input id="idUser" value=<?php echo "'$idUser'" ?> hidden>
	<div id="main_page" class="container">
	<?php if($showPage): ?>
		<div class="big-img-container" id=<?php echo "'$idhash'" ?>>
			<!-- header : infos et boutons partage -->
			<div class="big-img-titre"><a href='#'><?php echo $titre ?></a></div><br>
			<div class='temps'>
			<?php if($report==1 && !$showSupprime): ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Signalé" class="big-card-signal glyphicon glyphicon-warning-sign voted"></span>
					<?php elseif(!$showSupprime): ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Signaler" class="big-card-signal glyphicon glyphicon-warning-sign"></span>
					<?php endif ?>
					
					
					<?php if($supprime==0 && $showSupprime): ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Supprimer" class="big-card-remove glyphicon glyphicon-trash"></span>
					<?php elseif($showSupprime): ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Restaurer" class="big-card-remove glyphicon glyphicon-trash voted"></span>
					<?php endif ?>
			<?php if($showBan): ?>
					
					<span data-placement='bottom' data-toggle="tooltip" title="Supprimer et bannir" class="big-card-ban glyphicon glyphicon-ban-circle"></span>
				
			<?php endif ?>
			<?php if($showSupprime): ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Modifier" class="big-card-edit glyphicon glyphicon-pencil"></span>
			<?php endif ?>
				<span class="glyphicon glyphicon-time"></span> <span class="elapsed"></span><?php echo " par <a data-toggle='popover' data-html='true'>$pseudoUser</a>" ?>
				<input id="inscription" value="<?php echo $inscription ?>" hidden>
				<input id="pointsUser" value="<?php echo $pointsUser ?>" hidden>
				<input id="posts" value="<?php echo $posts ?>" hidden>
				<input id="pseudo" value="<?php echo $pseudoUser ?>" hidden>
				<input id="idUser" value="<?php echo $idUser ?>" hidden>
				

			</div>

			<div class="big-card-align">
				<div class="big-img-info">
					<div class="votes">
						<span data-toggle="tooltip" title="J'aime" class="glyphicon glyphicon-thumbs-up card-thumb-up <?php if($vote==1) echo 'voted' ?>" ></span>

						<span data-toggle="tooltip" title="J'aime pas" class="glyphicon glyphicon-thumbs-down card-thumb-down <?php if($vote==-1) echo 'voted' ?>" ></span>
					</div>
					<div class="points"><?php echo $points ?>  </div>

					<div class="big-share-group">

				<img data-placement='top' data-toggle="tooltip" title="Facebook" class="big-img-facebook" src="assets/Facebook.png"/>
				<img data-placement='top' data-toggle="tooltip" title="Twitter" class="big-img-twitter" src="assets/Twitter.png"/>
				<img data-placement='top' data-toggle="tooltip" title="Google Plus" class="big-img-gplus" src="assets/Google_plus.png"/>
					</div>		
				<span data-toggle="tooltip" title="Copier le lien" class="glyphicon glyphicon-link big-img-link" ></span>
				</div>
			<br>
			<center><img class="big-img" src=<?php echo "'$urlSource'" ?> /></center>
			
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
		</div>
	<?php else: ?>
	<div class='alert alert-danger erreur'>
	      <a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
			Oups ! Cette image n'existe pas !
		  </div>`

	<?php endif ?>
	</div>
</body>
</html>
