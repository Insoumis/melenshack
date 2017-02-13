<?php

include("includes/identifiants.php");
include_once('includes/token.class.php');
include_once('includes/securite.class.php');

if(Token::verifier(600, 'connexion')) 
{
	if(!empty($_POST['pseudo']) AND !empty($_POST['pass']))
	{

		  $pass = Securite::bdd($_POST['pass']);
		$pseudo = Securite::bdd($_POST['pseudo']);
		$pass_hache = hash('sha256','testsalt' . $pass); // !! changer le salt pour le site !!

		// Vérification des identifiants
		$req = $bdd->prepare('SELECT id FROM users WHERE pseudo = :pseudo AND pass = :pass');
		$req->execute(array(
			'pseudo' => $pseudo,
			'pass' => $pass_hache));

		$resultat = $req->fetch();

		if (!$resultat)
		{
			//Mauvais identifiant ou mot de passe
			header('Location:login.php?erreur=true');
		}
		else
		{
			if(!isset($_SESSION)){
			  session_start();
			}
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['pseudo'] = $pseudo;
			echo 'SUCCESS'; // Connecté !
			header('Location:index.php');

		}
	}
}

else {
     //Mauvais Token
	header('Location:login.php?erreur=true');
}

?>
