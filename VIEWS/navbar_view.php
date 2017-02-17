	<nav class="navbar navbar-light bg-faded navbar-fixed-top">
		<div class ="container">
		
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Activer la navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"><img src="assets/melenshack.svg" id="logo"/></a>
			</div> <!-- navbar-header -->
	
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li id="hot" <?php if($isHotActive) echo "class='actif'"; ?>>
						<a href="index.php?sort=hot">Populaire</a>
					</li>
					<li class="vdivide"></li>
					<li id="new" <?php if($isNewActive) echo "class='actif'"; ?>>
						<a href="index.php?sort=new">Nouveauté</a>
					</li>
					<li class="vdivide"></li>
					<li id="random" <?php if($isRandomActive) echo "class='actif'"; ?>>
						<a href="index.php?sort=random">Au Hasard</a>
					</li>
					<li class="btn-danger"><a id="ajouter_img" href="upload.php">Ajouter une image</a></li>
				</ul>
				
				<div class="navbar-right">
					<form class="navbar-form" role="search">
						<div class="input-group" id="droite_navbar">
							<input id="search_input" type="text" class="form-control" placeholder="Rechercher" name="recherche">
							<div class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
							</div>
						</div>
					
						<?php if(!$connexionButton) : ?>
						
						<a id="deconnection" class="btn btn-danger" role="button" href="disconnect_conf.php">Déconnexion</a>
						<input id="connected" value="yes" hidden/>	
						<?php else : ?>
						<a id="connexion" class="btn btn-danger" role="button" href="login.php">Connexion</a>
						<input id="connected" value="no" hidden />
						<?php endif; ?>
					</form>
	
				</div> <!-- navbar-right -->
			</div> <!-- navbar -->
		</div> <!-- container -->
	</nav>
