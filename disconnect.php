<meta charset=utf-8 /> 
<html>
<?php
include 'includes/header.php';
if(!isset($_SESSION)){
session_start();
}
if (isset($_SESSION['id']) && isset($_SESSION['pseudo']))
	{ ?>
<form method = "post" action = "disconnect_conf.php">
	<input type = "submit" value = "Se déconnecter"/>
</form>  
	<?php  } 
	else
	{ ?> 
	<p>Vous n'êtes pas connecté ! </p>
	Voulez vous <a href="login.php">vous connecter</a> ?

	<?php  } ?>

</html>
