<?php
	include_once('includes/token.class.php');
	$token = Token::generer('connexion');
?>

<!DOCTYPE html>
<html>
	<meta name="google-signin-client_id" content="370224579216-3m4vo3a5isrnthstrg5jga9so291r4an.apps.googleusercontent.com">
	<script src="https://apis.google.com/js/platform.js" async defer></script>

	<?php include 'includes/header.php';

	if (isset($_SESSION['id']) && isset($_SESSION['pseudo']))
	{
	
		echo "<div class='alert alert-success erreur'>
		  <strong>Vous êtes déjà connecté !</strong> Voulez vous <a href='disconnect.php'>vous déconnecter</a> ?
		  </div>";
		exit();
	}
	
	$erreur = $_GET['erreur'];
	if($erreur) {
		if($erreur == "wrong")
			$msg = "Nom d'utilisateur ou mot de passe invalide !";
		else if($erreur == "token")
			$msg = "Token invalide !";
		else
			$msg = "Veuillez réessayer";
	
		echo "<div class='alert alert-danger erreur'>
		  <strong>Erreur !</strong> $msg
		  </div>";
	}
?>

	<div class="container" id="main_page">
		<h1>Connexion</h1>
		<h5>Pas de compte ? <a href="register.php">Inscrivez-vous !</a></h5>
		<h5>Ou utilisez les réseaux sociaux :</h5>
	
		<div class="g-signin2" data-onsuccess="onSignInGoogle"></div>

		<form id="loginForm" action="login_conf.php"  method="post">
			<div class="form-group col-xs-5">
				<label for="pseudo"><h3>Nom d'utilisateur :</h3></label>
				<input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Nom d'utilisateur" required autofocus>
				<br>
				<label for="pass"><h3>Mot de passe :</h3></label>
				<input type="password" class="form-control" name="pass" id="pass" placeholder ="Mot de passe" required autofocus>
				<input type="hidden" name="token" id="token" value="<?php echo $token;?>">
				<br>
				<input type="submit" id="submit" class="btn btn-primary" name="submit" value="Connexion">
			</div>
		</form>
	</div>

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
</body>
</html>
