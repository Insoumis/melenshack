<?php
/*
ERREURS RENVOYEES :

wrong
token
banned

*/

include("includes/identifiants.php");
include_once('includes/token.class.php');
include_once('includes/securite.class.php');
include_once ("includes/constants.php");

if(Token::verifier(600, 'connexion')) 
{
	if(!empty($_POST['pseudo']) AND !empty($_POST['pass']))
	{

		  $pass = Securite::bdd($_POST['pass']);
		$pseudo = Securite::bdd($_POST['pseudo']);
		$pass_hache = hash('sha256',SALT_PASS . $pass); // !! changer le salt pour le site !!

		// Vérification des identifiants
		$req = $bdd->prepare('SELECT id FROM users WHERE pseudo = :pseudo AND pass = :pass');
		$req->execute([
			'pseudo' => $pseudo,
			'pass' => $pass_hache,
		]);

		$resultat = $req->fetch();

		if (!$resultat)
		{
			//Mauvais identifiant ou mot de passe
			header('Location:../login.php?erreur=wrong');
		}
		else
		{
			$id = $resultat['id'];

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

			if (!isset($_SESSION)) {
				session_start ();
			}
			$_SESSION['id'] = $id;
			$_SESSION['pseudo'] = $pseudo;
			header ('Location:../index.php');

		}
	}
}

else {
     //Mauvais Token
	header('Location:../login.php?erreur=token');
}

?>
