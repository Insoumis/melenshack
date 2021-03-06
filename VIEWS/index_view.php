<!DOCTYPE html>
<html lang="fr">
<?php echo $HEAD ?>

<body>
	<?php echo $NAVBAR ?>

	<input id='search_pseudo' value=<?php echo "'$search_pseudo'"; ?> hidden>
	<input id='search_tag' value=<?php echo "'$search_tags'"; ?> hidden>


	<!-- container principal -->
	<?php if($showPage): ?>
	<div id='main_page'>
	<?php if(!$tagLegislatives && !$tagCulture && !$concours && !$tagRennes && !$tagMelenphone && !$evenement): ?>
		<div id='concours' class='alert alert-info'>
				<a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
			    N'oubliez pas de suivre notre <a href="https://www.facebook.com/Melenshack" target="_blank"><strong>Facebook</strong></a> et notre <a href="https://www.twitter.com/Melenshack" target="_blank"><strong>Twitter</strong></a> !
		</div>
		<?php elseif($concours): ?>
			<!--<div id='concours' class='alert alert-success'>
					<a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
			
			</div>-->
		<?php elseif($evenement): ?>
			<div id='concours' class='alert alert-success'>
					<a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
					Vous êtes sur la page de l'événement du <strong>18 Mars</strong> ! Visionnez et partagez les archives du concours #JaiBastille et des photos de la marche !
			</div>
		<?php elseif($tagMelenphone): ?>
			<div id='concours' class='alert alert-success'>
				<a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
				Vous êtes sur la page de l'événement 50.000 appels du <strong><a href="https://melenphone.fr/ng/">Melenphone</a></strong> ce jeudi 20 avril. Partagez ces visuels ou concevez vous même vos visuels à propos de cet événement !
			</div>

		<?php elseif($tagRennes): ?>
		<div id='concours' class='alert alert-success'>
			<a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
			Vous êtes sur la page de l'événement du meeting de Rennes. Visionnez et partagez les archives de ce meeting !
		</div>

		<?php elseif($tagCulture): ?>
		<div id='concours' class='alert alert-success'>
			<a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
			Vous êtes sur la page de l'émission CULTURE INSOUMISE de la WebRadio du Discord Insoumis.<br> Votez pour les &oelig;uvres culturelles que vous trouvez les plus intéressantes et que vous souhaitez promouvoir !	


		</div>

		<?php elseif($tagLegislatives): ?>
		<div id='concours' class='alert alert-success'>
			<a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
			Vous êtes sur la page regroupant tous les visuels concernant les législatives ! Pour poster votre visuel, <a href='upload.php?tag=visuel_legislatives'>cliquez ici !</a><br>(Assurez-vous d'ajouter le tag <strong>visuel_legislatives</strong>)


		</div>

		<?php endif ?>

	<div class="big-card-container" hidden>
	<div class="big-card-overlay">
		<div class="big-card">
				
				<?php if(!$showSupprime): ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Signaler" class="big-card-signal glyphicon glyphicon-warning-sign"></span>
					<span data-placement='bottom' data-toggle="tooltip" title="Supprimer" class="big-card-remove glyphicon glyphicon-trash"></span>
					<span data-placement='bottom' data-toggle="tooltip" title="Modifier" class="big-card-edit glyphicon glyphicon-pencil"></span>
				<?php else: ?>

				<?php if($sort == "deleted"): ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Restaurer" class="big-card-remove glyphicon glyphicon-trash voted"></span>
					<span data-placement='bottom' data-toggle="tooltip" title="Supprimer définitivement" class="big-card-sup-def glyphicon glyphicon-erase"></span>
			    <?php else: ?>
					<span data-placement='bottom' data-toggle="tooltip" title="Supprimer" class="big-card-remove glyphicon glyphicon-trash"></span>
					<span data-placement='bottom' data-toggle="tooltip" title="Supprimer et bannir" class="big-card-ban glyphicon glyphicon-ban-circle"></span>
					<span data-placement='bottom' data-toggle="tooltip" title="Modifier" class="big-card-edit glyphicon glyphicon-pencil"></span>
				<?php endif ?>
				<?php endif ?>

				
				<div class="big-card-infos form-inline">
					<span class="glyphicon glyphicon-time"></span> <span class="big-card-tmps"></span> par <strong><a data-placement='bottom' data-toggle='popover' data-html="true" class="big-img-author" href='#'></a></strong>
				</div>
				<span data-placement='bottom' data-toggle="tooltip" title="Fermer" class="big-card-close glyphicon glyphicon-remove"></span>

			
			<div class="big-card-title">
			</div>
			
			<div class="big-card-align">

			<div class="big-card-share">
				<img alt="facebook" data-toggle="tooltip" title="Facebook" class="big-card-facebook" src="/assets/Facebook.png"/>
				<img alt="twitter" data-toggle="tooltip" title="Twitter" class="big-card-twitter" src="/assets/Twitter.png"/>
				<img alt="gplus" data-toggle="tooltip" title="Google Plus" class="big-card-gplus" src="/assets/Google_plus.png"/>
				<span data-toggle="tooltip" title="Copier le lien" class="glyphicon glyphicon-link big-card-link" ></span>
			</div>

			
			<div class="big-card-votes">
		   
				<span data-toggle="tooltip" title="J'aime pas" class="glyphicon glyphicon-thumbs-down card-thumb-down" ></span>
				<span data-toggle="tooltip" title="J'aime" class="glyphicon glyphicon-thumbs-up card-thumb-up" ></span>
			</div>
			<div class="big-card-points">352</div>

			<br>
			<div class="big-card-img">
				<img alt='grande image' class='big-card-img' src="/assets/looper.gif" />
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
				<div class="gif-overlay" hidden><img alt='chargement...' src="/assets/gif_overlay.png"/></div>
				<img src="/assets/looper.gif" />
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
				<img alt="facebook" data-toggle="tooltip" title="Facebook" class="card-facebook" src="/assets/Facebook.png"/>
				<img alt='twitter' data-toggle="tooltip" title="Twitter" class="card-twitter" src="/assets/Twitter.png"/>
				<img alt="gplus" data-toggle="tooltip" title="Google Plus" class="card-gplus" src="/assets/Google_plus.png"/>

			</div>
	</div>


</div>

</div>

</div>
<?php endif ?>
<script src="/libs/bootstrap-tagsinput.min.js" defer></script>
<script src="/CONTROLLERS/JS/common_card.js" defer></script>
<script src="/CONTROLLERS/JS/index.js?c=cb2" defer></script>
</body>
</html>
