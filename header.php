
<body>

<nav class="navbar navbar-light bg-faded navbar-fixed-top">
	<div class ="container">
	<div class="navbar-header">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		<span class="sr-only">Activer la navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<a class="navbar-brand" href="index.php">MELUCHE</a>
	</div>
	<div id="navbar" class="collapse navbar-collapse">
		<ul class="nav navbar-nav">
			<li class="active"><a href="chaud.html">Populaire</a></li>
			<li class="vdivide"></li>
			<li><a href="nouveau.html">Nouveauté</a></li>
			<li class="vdivide"></li>
			<li><a href="pif.html">Au Hasard</a></li>
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
		<?php if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])) { ?>
			<a id="deconnection" class="btn btn-danger" role="button" href="disconnect.php">Deconnexion</a>
		<?php } else { ?>
			<a id="connexion" class="btn btn-danger" role="button" href="login.php">Connexion</a>
		<?php } ?>
		</form>
		</div>

	</div>
	</div>
</nav>

