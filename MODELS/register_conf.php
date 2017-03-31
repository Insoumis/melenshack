<?php

/*
ERREURS RENVOYEES :

captcha
doublon
pass
email
loginmdp
token



*/
include("includes/identifiants.php");
include_once('includes/securite.class.php');
include_once('includes/token.class.php');
include_once ("includes/constants.php");
include_once('auth_cookie.php');

if(Token::verifier(600, 'inscription')) 
{
  if(!empty($_POST['g-recaptcha-response']) && !empty($_POST['pseudo']) AND !empty($_POST['pass']) AND !empty($_POST['confpass']) AND !empty($_POST['email']))
  {
  	$captcha = $_POST['g-recaptcha-response'];
	if (!$captcha) {
    	header ('Location:../register.php?erreur=captcha');
		//echo 'captcha1';
    	exit();
	}
	
	// Verification de la validité du captcha
	$response = file_get_contents ("https://www.google.com/recaptcha/api/siteverify?secret=6LeKlhgUAAAAAJGHPPA35YtfqvOHfH89BB9xvipi&response=" . $captcha);
	$decoded_response = json_decode ($response);
	if ($decoded_response->success == false) {
    	header ('Location:../register.php?erreur=captcha');
		//echo 'captcha2';
    	exit();
	}


	$email = $_POST['email'];
	$pseudo = $_POST['pseudo'];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
	{
		$pass = Securite::bdd($_POST['pass']);
		$confpass = Securite::bdd($_POST['confpass']);


		if ($pass == $confpass) 
		{
			
			$req = $bdd->prepare('SELECT id FROM classic_users WHERE username = :pseudo OR email = :email');
			$req->execute([
				'pseudo' => $pseudo,
				'email' => $email,
			]);
				
			$resultat = $req->fetch();
			if (!$resultat)
			{
			
				$pseudo = htmlspecialchars($_POST['pseudo']);
				$pass_hache = password_hash(
					base64_encode(hash('sha384', $pass, true))
								, PASSWORD_DEFAULT);
			 	// Insertion du message à l'aide d'une requête préparée
				$req = $bdd->prepare('INSERT INTO users(dateinscription) VALUES(NOW());');
				$req->execute();

				$id = $bdd->lastInsertId();

				$req = $bdd->prepare('INSERT INTO classic_users(id_user, username, pass, email) VALUES(:id_user, :username, :pass, :email)');
				$req->execute([
					'id_user' => $id,
					':username' => $pseudo,
					':pass' => htmlspecialchars($pass_hache),
					':email' => htmlspecialchars($email)
				]);
								   
				echo 'SUCCESS'; // Inscription réussie !
						
				if(!isset($_SESSION)){
				  session_start();
				}
				$_SESSION['id'] = $id;
				
				//remember me
			
				if(isset($_POST['rememberme'])) {
					createCookie($id);
				}
				
				//vérifie si pseudo déja pris
				$req = $bdd->prepare("SELECT * FROM users WHERE pseudo=:pseudo");
				$req->execute([
					':pseudo' => $pseudo
				]);
				$res = $req->fetch();

				if($res) { //pseudo deja pris, user doit le changer
					header("Location:../pseudo.php?erreur=fromregister&pseudo=".$pseudo);
					exit();
				}

				$req = $bdd->prepare("UPDATE users SET pseudo=:pseudo WHERE id=:id");
				$req->execute([
					':pseudo' => $pseudo,
					':id' => $id
				]);


				$_SESSION['pseudo'] = $pseudo;
						
				header('Location:../index.php');
				exit();
			}
			else 
			{
			   // Doublon Pseudo ou email
			  header('Location:../register.php?erreur=doublon');
				//echo 'Doublon';
			}
		}
		else 
		{
		  // Mauvais Mot de passe 
		  header('Location:../register.php?erreur=pass');
			//echo 'pass';
		}
	}
	else 
	{
	   // Mauvais email
	   header('Location:../register.php?erreur=email');
		//echo 'email';
	}
  } 
  else 
  {
 // Mauvais Mot de passe ou Login
	header('Location:../register.php?erreur=loginmdp');
	  //echo 'loginmdp';
  }
}
else 
{
    //Mauvais Token
	header('Location:../register.php?erreur=token');
	//echo 'token';
}
?>
