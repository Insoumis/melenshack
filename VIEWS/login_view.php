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

		<div id="login_container">

		<div class="login-social" id="facebook_login">
		<img class='loginLogo' src="assets/Facebook_logo.png" />
		<div class="main">Continuer avec Facebook</div>
		<div class="sub">Rien ne sera posté sans votre permission</div>
		</div>

		<div class="login-social" id="twitter_login">
		<img class='loginLogo' src="assets/Twitter_logo.png" />
		<div class="main">Continuer avec Twitter</div>
		<div class="sub">Rien ne sera posté sans votre permission</div>
		</div>

		<div class="login-social" id="google_login">
		<img class='loginLogo' src="assets/Google_logo.png" />
		<div class="main">Continuer avec Google</div>
		</div>

		<div class="login-social" id="mail_login">
		<img class='loginLogo' src="assets/Email_logo.png" />
		<div class="main">Continuer avec un email</div>
		</div>

		</div>
		<?php endif ?>

		</div>
	</body>
</html>
