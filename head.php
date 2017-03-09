<head>

	
	<meta property="og:url"                content=<?php echo "'http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]'" ?> >
	<meta property="og:type"               content="article" >
	<meta property="og:locale"              content="fr_FR" >
	<meta property="og:description"        content="Mélenshack, la banque d'images de la France Insoumise !" >
	<meta property="og:app_id"              content="1849815745277262" >
	<?php if(isset($urlSource)): ?>
	<meta property="og:title"              content=<?php echo "'$titre'" ?> >
	<meta property="og:image"              content=<?php echo "'http://$_SERVER[HTTP_HOST]".dirname($_SERVER['REQUEST_URI'])."/$urlSource'" ?> >
	<meta property="og:image:width"              content=<?php echo "'$width'" ?> >
	<meta property="og:image:height"              content=<?php echo "'$height'" ?> >
	<?php endif ?>
	

	<meta charset="utf-8">
	<meta name="description" content="La banque d'images de la France Insoumise">
	<title>Mélenshack</title>
	<link rel="icon" type="image/png" href="assets/melenshack_small.png">
	<link href="https://fonts.googleapis.com/css?family=Roboto:700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/bootstrap-tagsinput.css"/>

	<script src="libs/jquery.min.js"></script>
	<script src="libs/jquery-ui.min.js"></script><!-- ATTENTION : JQUERY UI AVANT BOOTSTRAP SINON PB TOOLTIP -->
	<script src="libs/bootstrap.min.js"></script>
	<script src="libs/clipboard.min.js"></script>
	<script src="libs/masonry.pkgd.min.js"></script>
	<script src="libs/imagesloaded.pkgd.min.js"></script>


	
</head>
