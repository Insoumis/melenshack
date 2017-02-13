<?php
include_once('includes/token.class.php');
$token = Token::generer('connexion')
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
</head>

<?php
if (isset($_SESSION['id']) && isset($_SESSION['pseudo']))
       { ?>
        <p>Vous êtes déja connecté !</p>
        Voulez vous <a href="disconnect.php">vous déconnecter</a> ?
<?php  }
else
{
?>
<body>

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
Voulez vous <a href="register.php">inscrire</a> ?
<?php  } ?>

</body>
</html>
