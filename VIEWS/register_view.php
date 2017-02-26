<!DOCTYPE html>
<html lang="fr">
<?php echo $HEAD ?>

<body>
	<?php echo $NAVBAR ?>
	<div class="container" id="main_page">
		<?php if(!empty($errmsg)): ?>
			<div class='alert alert-danger erreur'>
	      <a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
				<?php echo $errmsg ?>
			</div>
		<?php endif ?>
		<?php if($showPage): ?>
	
			<form id="registerForm" action="MODELS/register_conf.php"  method="post">
				<h1>Inscription</h1>
				<div class="sub">Vous avez déjà un compte ? <a href="login.php">Connectez-vous !</a></div>
				<div class="form-group col-xs-4">
					<label for="pseudo">Nom d'utilisateur :</label>
					<input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Nom d'utilisateur" required autofocus>
					<label for="pass">Mot de passe :</label>
					<input type="password" class="form-control" name="pass" id="pass" placeholder ="Mot de passe" required autofocus>
					<label for="pass">Confirmation du mot de passe :</label>
					<input type="password" class="form-control" name="confpass" id="confpass" placeholder ="Retapez votre mot de passe" required autofocus>
					<label for="email">Adresse mail :</label>
					<input type="email" class="form-control" name="email" id="email" placeholder ="Votre email" required autofocus>
					<div class="checkbox">
						<label><input type="checkbox" name="rememberme" value="rememberme">Se souvenir de moi</label>
					</div>
					<input type="hidden" name="token" id="token" value="<?php echo $token ?>">
					<div class="g-recaptcha" data-sitekey=<?php echo "'$googleKey'" ?> data-callback="recaptchaCallback"></div>
					<br>
					<input disabled type="submit" id="submit" class="btn btn-primary btn-lg" name="submit" value="Inscription">
				</div>
			</form>
	
		<?php endif ?>
	</div>
</body>
</html>
