<?php
include_once('includes/token.class.php');
$token = Token::generer('inscription')
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
</head>

<?php
if (isset($_SESSION['id']) && isset($_SESSION['pseudo']))
       { ?>
        <p>Vous etes déja connecter !</p>
        Voulez vous <a href="disconnect.php">vous déconnecter</a> ?
<?php  }
else { ?>
<body>

<div id="formulaire"> 
	<form name="registerForm" id="registerForm" action="register_conf.php" method = "post">
					<p>
						<label for = "pseudo"><strong>Pseudo :</strong></label>
						<input type = "text" name = "pseudo" id = "pseudo" required placeholder="Votre pseudo"/><br/>
						
						<label for = "pass"><strong>Mot de passe :</strong></label>
						<input type ="password" name = "pass" id = "pass" required placeholder="Votre mot de passe"/><br/>
						
						<label for = "confpass"><strong>Confirmation du mot de passe :</strong></label>
						<input type ="password" name = "confpass" id = "confpass" required placeholder="Retapez votre mot de passe"/><br/>
						
						<label for = "email"><strong>Email :</strong></label>
						<input type ="text" name = "email" id = "email" required placeholder="Votre email"/><br/>
						
						<input type="hidden" name="token" id="token" value="<?php echo $token;?>"/>
						<input type = "submit" value = "Envoyer"/>
					</p>
	</form>
	
</div>

Voulez vous <a href="login.php">connecter</a> ?
<?php  } 
if(!empty($_GET['erreur'])) {
?>
<p> Erreur lors de l'inscription </p>
<?php	
}
?>


</body>
</html>
