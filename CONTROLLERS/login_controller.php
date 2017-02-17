<?php

require_once ('MODELS/includes/token.class.php');

$token = Token::generer('connexion');

$errmsg = "";
$showPage = true;
if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])) {
	
		$errmsg = "<strong>Vous êtes déjà connecté !</strong> Voulez vous <a href='disconnect.php'>vous déconnecter</a> ?";
		$showPage = false;
} else if (isset($_GET['erreur']) && !empty($_GET['erreur'])) {
	$erreur = $_GET['erreur'];
	if ($erreur == "wrong")
		$errmsg = "Nom d'utilisateur ou mot de passe invalide !";
	else if ($erreur == "token")
		$errmsg = "Token invalide ! Veuillez réessayer";
	else
		$errmsg = "Veuillez réessayeri !";
}
?>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>
	function onSignInGoogle(gUser) {
		var id_token = gUser.getAuthResponse().id_token;
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'googleTokenSignin.php');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			window.location.replace("index.php");
		};
		xhr.send('idtoken=' + id_token);
	}
</script>

