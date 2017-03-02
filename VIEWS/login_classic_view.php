<!DOCTYPE html>
<html lang="fr">
	<?php echo $HEAD ?>
	<meta name="google-signin-client_id" content="370224579216-3m4vo3a5isrnthstrg5jga9so291r4an.apps.googleusercontent.com">
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
			<form id="loginForm" action="MODELS/login_conf.php"  method="post">
				<h1>Connexion</h1>
				<h5 class="sub">Pas de compte ? <a href="register.php">Inscrivez-vous !</a></h5>
				<!--<h5>Ou utilisez les réseaux sociaux :</h5>

				-->	
				<div class="form-group col-xs-4">
					<label for="pseudo">Nom d'utilisateur :</label>
					<input type="text" class="form-control input-lg" name="pseudo" id="pseudo" placeholder="Nom d'utilisateur" required autofocus>
					<label for="pass">Mot de passe :</label>
					<input type="password" class="form-control input-lg" name="pass" id="pass" placeholder ="Mot de passe" required autofocus>
					<div class="checkbox">
						<label><input type="checkbox" name="rememberme" value="rememberme">Se souvenir de moi</label>
					</div>
					<input type="hidden" name="token" id="token" value="<?php echo $token?>">
					<br><input type="submit" id="submit" class="btn btn-primary btn-lg" name="submit" value="Connexion">
				</div>
			</form>
			<?php endif ?>
		</div>
	</body>
</html>
