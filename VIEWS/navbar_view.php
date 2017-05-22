	<nav class="navbar navbar-light bg-faded navbar-fixed-top">
		<div class ="container">
		
			<div class="navbar-header">
				<a class="navbar-brand" href="/"><img alt="melenshack" class="hidden-xs" src="/assets/melenshack.svg" id="logo"/>
														 <img alt="melenshack" class="visible-xs" src="/assets/melenshack_text.svg" id="logo"/></a>
			</div> <!-- navbar-header -->
	
			<div id="navbar" class="flexnav">
				<ul class="nav navbar-nav">
					<li title="Populaire" id="hot" <?php if($isHotActive && $_REQUEST['tag'] != "visuel_legislatives" && $_REQUEST['tag'] != "20mars" && $_REQUEST['tag'] != "culture_insoumise") echo "class='actif'"; ?>>
						<a href="/hot"><div class="hidden-sm hidden-xs">Populaire</div><span class="glyphicon glyphicon-fire visible-sm visible-xs icon"></span></a>
					</li>
					<li class="vdivide"></li>
					<li title="Nouveauté" id="new" <?php if($isNewActive ) echo "class='actif'"; ?>>
						<a href="/new"><div class="hidden-sm hidden-xs">Nouveauté</div><span class="glyphicon glyphicon-time visible-sm visible-xs icon"></span></a>
					</li>
					<li class="vdivide"></li>
					<li title="Le Meilleur" id="top" <?php if($isTopActive && $_REQUEST['tag'] != "concours" && $_REQUEST['tag'] != "18mars" && $_REQUEST['tag'] != "rennes" && $_REQUEST['tag'] != "ressources") echo "class='actif'"; ?>>
						<a href="/top"><div class="hidden-sm hidden-xs">Le Meilleur</div><span class="glyphicon glyphicon-heart-empty visible-sm visible-xs icon"></span></a>
					</li>
					<li class="vdivide"></li>
					<li id="plus" data-toggle="popover" data-html="true" title="" data-content="
						<a href='/random'><span class='glyphicon glyphicon-random'></span>Aléatoire</a>
						<br><br>
						<a href='/archives.php'><span class='glyphicon glyphicon-book'></span>Archives</a>
						<br><br>
						<a href='/ressources'><span class='glyphicon glyphicon-hdd'></span>Ressources</a>
						<br></br>
						<a href='/apropos.php'><span class='glyphicon glyphicon-question-sign'></span>A propos</a>
						<br></br>
						<a href='/mentions-legales'><span class='glyphicon glyphicon-question-sign'></span>Mentions Légales</a>
						" data-placement="bottom">



						<a><span class="glyphicon glyphicon-menu-down icon"></span></a>
					</li>
					<li title="Ajouter une image" class="btn-danger"><a id="ajouter_img" href="/upload.php"><div class="hidden-sm hidden-xs">Ajouter une image</div><span class="glyphicon glyphicon-cloud-upload visible-sm visible-xs icon"></span></a></li>
				</ul>
				<div style="flex: 1">
				<?php if($showSearch): ?>
						<input id="searchinput" placeholder="Rechercher..." type="text" name="search" autocomplete="off" value='<?php if (!empty($_GET["search"])) echo htmlspecialchars($_GET["search"]); ?>'/>

				<?php endif ?>
				</div>
				<ul class="nav navbar-nav pull-right" id="right">
						<?php if(!$connexionButton) : ?>
						<li id="decoli">
						<img alt="" data-toggle="popover" data-html="true" title="<strong><?php echo $pseudo ?></strong><a title='Paramètres'  href='/settings.php' class='settings'><span class='glyphicon glyphicon-wrench'></span></a>" data-content="
						<a href='/index.php?sort=new&pseudo=<?php echo $_SESSION['pseudo'] ?>'><span class='glyphicon glyphicon glyphicon-user'></span>Mes posts</a>
						<br><br>
						<a href='/pseudo.php'><span class='glyphicon glyphicon glyphicon-pencil'></span>Changer mon pseudo</a>
						<br><br>
						<?php if($grade >= 5): ?>

						<a href='/admin.php'><span class='glyphicon glyphicon glyphicon-cog'></span>Modération</a>
						<br><br>


						<?php endif ?>
						<a href='/MODELS/disconnect_conf.php'><span class='glyphicon glyphicon glyphicon-log-out'></span>Se déconnecter</a>



						" data-placement="bottom" src="/assets/phi.png"/>
						<!--<a title="Déconnexion" id="deconnection" href="MODELS/disconnect_conf.php"><div class="hidden-xs">Déconnexion</div><span class="visible-xs glyphicon glyphicon-log-out icon"></span></a>-->
						</li>
						<input id="connected" value="yes" hidden/>	
						<?php else : ?>
						<li title="Connexion" id="coli" class="btn-danger">
						<a id="connexion" href="/login.php"><div class="hidden-xs">Connexion</div><span class="visible-xs glyphicon glyphicon-log-in icon"></span></a>
						</li>
						<input id="connected" value="no" hidden />
						<?php endif; ?>
						</ul>
						<input id="id_user" value=<?php echo "'$id_user'" ?> hidden />
						<input id="grade" value=<?php echo "'$grade'" ?> hidden />
				<div class="token" id="token" hidden><?php echo $token_A; ?></div>
			</div> <!-- navbar -->
		</div> <!-- container -->
	</nav>
