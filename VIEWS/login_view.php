<!DOCTYPE html>
<html>
<?php echo $HEAD ?>
<meta name="google-signin-client_id" content="370224579216-3m4vo3a5isrnthstrg5jga9so291r4an.apps.googleusercontent.com">
<body>
	<?php echo $NAVBAR ?>
	<div class="container" id="main_page">
	
		<?php if(!empty($errmsg)): ?>
			<div class='alert alert-danger erreur'>
				<?php echo $errmsg ?>
			</div>
		<?php endif ?>
		
		<?php if($showPage): ?>
			<h1>Connexion</h1>
			<h5>Pas de compte ? <a href="register.php">Inscrivez-vous !</a></h5>
			<!--<h5>Ou utilisez les réseaux sociaux :</h5>
			
				<div class="g-signin2" data-onsuccess="onSignInGoogle"></div>
			-->	
			<form id="loginForm" action="MODELS/login_conf.php"  method="post">
				<div class="form-group col-xs-5">
					<label for="pseudo"><h3>Nom d'utilisateur :</h3></label>
					<input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Nom d'utilisateur" required autofocus>
					<br>
					<label for="pass"><h3>Mot de passe :</h3></label>
					<input type="password" class="form-control" name="pass" id="pass" placeholder ="Mot de passe" required autofocus>
					<input type="hidden" name="token" id="token" value="<?php echo $token?>">
					<br>
					<input type="submit" id="submit" class="btn btn-primary" name="submit" value="Connexion">
				</div>
			</form>
		<?php endif ?>
	</div>
</body>
</html>
