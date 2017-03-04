	<nav class="navbar navbar-light bg-faded navbar-fixed-top">
		<div class ="container">
		
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php"><img class="hidden-xs" src="assets/melenshack.svg" id="logo"/>
														 <img class="visible-xs" src="assets/melenshack_text.svg" id="logo"/></a>
			</div> <!-- navbar-header -->
	
			<div id="navbar" style="display: flex;">
				<ul class="nav navbar-nav">
					<li title="Populaire" id="hot" <?php if($isHotActive) echo "class='actif'"; ?>>
						<a href="index.php?sort=hot"><div class="hidden-sm hidden-xs">Populaire</div><span class="glyphicon glyphicon-fire visible-sm visible-xs icon"></span></a>
					</li>
					<li class="vdivide"></li>
					<li title="Nouveauté" id="new" <?php if($isNewActive) echo "class='actif'"; ?>>
						<a href="index.php?sort=new"><div class="hidden-sm hidden-xs">Nouveauté</div><span class="glyphicon glyphicon-time visible-sm visible-xs icon"></span></a>
					</li>
					<li class="vdivide"></li>
					<li title="Au Hasard" id="random" <?php if($isRandomActive) echo "class='actif'"; ?>>
						<a href="index.php?sort=random"><div class="hidden-sm hidden-xs">Au Hasard</div><span class="glyphicon glyphicon-random visible-sm visible-xs icon"></span></a>
					</li>
					<li title="Ajouter une image" class="btn-danger"><a id="ajouter_img" href="upload.php"><div class="hidden-sm hidden-xs">Ajouter une image</div><span class="glyphicon glyphicon-cloud-upload visible-sm visible-xs icon"></span></a></li>
				</ul>
				<div style="flex: 1">
				<?php if($showSearch): ?>
						<input id="searchinput" placeholder="Rechercher..." type="text" name="search" autocomplete="off"></input>

				<?php endif ?>
				</div>
				<ul class="nav navbar-nav pull-right" id="right">
						<?php if(!$connexionButton) : ?>
						<li id="decoli">
						<img data-toggle="popover" data-html="true" title=<?php echo "'<strong>$pseudo</strong>'"?> data-content="
						<a href='index.php?sort=new&pseudo=<?php echo $_SESSION['pseudo'] ?>'><span class='glyphicon glyphicon glyphicon-user'></span>Mes posts</a>
						<br><br>
						<a href='pseudo.php'><span class='glyphicon glyphicon glyphicon-pencil'></span>Changer mon pseudo</a>
						<br><br>
						<?php if($grade > 0): ?>

						<a href='admin.php'><span class='glyphicon glyphicon glyphicon-cog'></span>Modération</a>
						<br><br>


						<?php endif ?>
						<a href='MODELS/disconnect_conf.php'><span class='glyphicon glyphicon glyphicon-log-out'></span>Se déconnecter</a>



						" data-placement="bottom" src="assets/phi.png"/>
						<!--<a title="Déconnexion" id="deconnection" href="MODELS/disconnect_conf.php"><div class="hidden-xs">Déconnexion</div><span class="visible-xs glyphicon glyphicon-log-out icon"></span></a>-->
						</li>
						<input id="connected" value="yes" hidden/>	
						<?php else : ?>
						<li title="Connexion" id="coli" class="btn-danger">
						<a id="connexion" href="login.php"><div class="hidden-xs">Connexion</div><span class="visible-xs glyphicon glyphicon-log-in icon"></span></a>
						</li>
						<input id="connected" value="no" hidden />
						<?php endif; ?>
						</ul>
						<input id="id_user" value=<?php echo "'$id_user'" ?> hidden />
						<input id="grade" value=<?php echo "'$grade'" ?> hidden />
			</div> <!-- navbar -->
		</div> <!-- container -->
	</nav>

	
<script defer>
	$('#searchinput').on('keypress', function(e) {
		if(e.which ===13) {//Enter
			window.location.href = 'search.php?s=' + $(this).val();
		}
	});

</script>
