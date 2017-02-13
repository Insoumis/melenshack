<?php
include_once('includes/token.class.php');
$token = Token::generer('connexion')
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>MELUCHE <3</title>
	<meta name="description" content="La banque d'images de la France Insoumise">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<link rel="stylesheet" href="style.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous" defer async></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>

<?php
include("header.php");

if (isset($_SESSION['id']) && isset($_SESSION['pseudo']))
       { ?>
		<div class="container" id="login_page">
			<p>Vous êtes déja connecté !</p>
			Voulez vous <a href="disconnect.php">vous déconnecter</a> ?
		</div>
<?php  }
else
{
?>
<div class="container" id="login_page">
	<div id="formulaire">
		<form name="loginForm" id="loginForm" action="login_conf.php" method = "post">
						<p>
							<label for = "pseudo"><strong>Pseudo :</strong></label>
							<input type = "text" name = "pseudo" id = "pseudo"/><br/>
							
							<label for = "pass"><strong>Mot de passe :</strong></label>
							<input type = "password" name = "pass" id = "pass" required placeholder="Votre mot de passe"/><br/>
							
							<input type="hidden" name="token" id="token" value="<?php echo $token;?>"/>
							<input type = "submit" value = "Envoyer"/>
						</p>
		</form>
	</div>
Voulez-vous vous <a href="register.php">inscrire</a> ?
</div>
<?php  } ?>

</body>
</html>
