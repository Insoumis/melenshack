<?php
/*
ERREURS RENVOYEES :

wrong
token
banned

*/

include_once("includes/identifiants.php");
include_once('includes/token.class.php');
include_once('includes/securite.class.php');
include_once ("includes/constants.php");
include_once("auth_cookie.php");

if(Token::verifier(600, 'connexion')) 
{
	if(!empty($_POST['pseudo']) AND !empty($_POST['pass']))
	{

		  $pass = Securite::bdd($_POST['pass']);
		$pseudo = Securite::bdd($_POST['pseudo']);

		// Vérification des identifiants
		$req = $bdd->prepare('SELECT id_user, pass FROM classic_users WHERE username = :pseudo');
		$req->execute([
			'pseudo' => $pseudo,
		]);

		$resultat = $req->fetch();

		if (!$resultat)
		{
			//Mauvais identifiant ou mot de passe
			header('Location:../login.php?erreur=wrong');
			exit();
		}
		else
		{
			$pass_hash = $resultat['pass'];

			if(!password_verify(base64_encode(hash('sha384', $pass, true)), $pass_hash)) {
				header('Location:../login.php?erreur=wrong');
				exit();
			}


			$id = $resultat['id_user'];

			$req = $bdd->prepare ('SELECT id FROM ban WHERE id_user = :id_user');
			$req->execute ([
				'id_user' => $id,
			]);
			$resultat = $req->fetch ();

			if ($resultat) {
				//La marteau du ban a frappé :)
				header ('Location:../login.php?erreur=banned');
				exit();
			}

			//remember me
			
			if(isset($_POST['rememberme'])) {
				createCookie($id);
			}
			
			$req = $bdd->prepare ('SELECT pseudo FROM users WHERE id = :id_user');
			$req->execute ([
				'id_user' => $id,
			]);
			$resultat = $req->fetch ();

			if (!isset($_SESSION)) {
				session_start ();
			}
			$_SESSION['id'] = $id;
			if($resultat['pseudo'])
				$_SESSION['pseudo'] = $resultat['pseudo'];
			$_SESSION['type'] = 'classic';
			header ('Location:../index.php');

		}
	}
}

else {
     //Mauvais Token
	header('Location:../login.php?erreur=token');
}

?>
