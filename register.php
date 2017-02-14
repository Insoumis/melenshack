<?php
	include_once('includes/token.class.php');
	$token = Token::generer('inscription')
?>

<!DOCTYPE html>
<html lang="fr">
<?php include 'includes/header.php';

if($_GET['erreur']) {
	echo "<div class='alert alert-danger'<strong>Erreur !</strong> Une erreur est survenue, veuillez réesayer.</div>";
}
?>



<?php
if (isset($_SESSION['id']) && isset($_SESSION['pseudo']))
       { ?>
        <p>Vous etes déja connecté !</p>
        Voulez vous <a href="disconnect.php">vous déconnecter</a> ?
<?php  }
else { ?>
<body>
	<script src='https://www.google.com/recaptcha/api.js'></script>

	<div class="container" id="main_page">
		<h1>Inscription</h1>
		<h5>Vous avez déjà un compte ? <a href="login.php">Connectez-vous !</a></h5>
		<form id="registerForm" action="register_conf.php"  method="post">
			<div class="form-group col-xs-5">
				<label for="pseudo"><h3>Nom d'utilisateur :</h3></label>
				<input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Nom d'utilisateur" required autofocus>
				<br>
				<label for="pass"><h3>Mot de passe :</h3></label>
				<input type="password" class="form-control" name="pass" id="pass" placeholder ="Mot de passe" required autofocus>
				<br>
				<label for="pass"><h3>Confirmation du mot de passe :</h3></label>
				<input type="password" class="form-control" name="confpass" id="confpass" placeholder ="Retapez votre mot de passe" required autofocus>
				<br>
				<label for="email"><h3>Adresse mail :</h3></label>
				<input type="email" class="form-control" name="email" id="email" placeholder ="Votre email" required autofocus>
				<br>
				<input type="hidden" name="token" id="token" value="<?php echo $token;?>">
				<div class="g-recaptcha" data-sitekey="6LefaBUUAAAAALVKIo2DiW_hWLs2kijFTrlUHGMb" data-callback="recaptchaCallback"></div>
				<br>
				<input disabled type="submit" id="submit" class="btn btn-primary" name="submit" value="Inscription">
			</div>
		</form>	
	</div>

<?php  } 
if(!empty($_GET['erreur'])) {
?>
<p> Erreur lors de l'inscription </p>
<?php	
}
?>

<script>

function recaptchaCallback() {
	$("#submit").prop("disabled", false);
}

</script>
</body>
</html>
