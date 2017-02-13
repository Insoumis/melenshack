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

<?php include 'includes/header.php'; 

if (isset($_SESSION['id']) && isset($_SESSION['pseudo']))
       { ?>
        <p>Vous êtes déja connecté !</p>
        Voulez vous <a href="disconnect.php">vous déconnecter</a> ?
<?php  }
else
{
?>

<div class="container" id="main_page">
	<h1>Connexion</h1>
	<h5>Pas de compte ? <a href="register.php">Inscrivez-vous !</a></h5>
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

<?php  } ?>

</body>
</html>
