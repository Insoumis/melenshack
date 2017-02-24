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

if(Token::verifier(600, 'connexion')) 
{
	if(!empty($_POST['pseudo']) AND !empty($_POST['pass']))
	{

		  $pass = Securite::bdd($_POST['pass']);
		$pseudo = Securite::bdd($_POST['pseudo']);

		// Vérification des identifiants
		$req = $bdd->prepare('SELECT id, pass FROM users WHERE pseudo = :pseudo');
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

			//remember me
			
			if(isset($_POST['rememberme'])) {
				$req = $bdd->prepare ('SELECT * FROM auth_tokens WHERE id_user = :id_user');
				$req->execute ([
					'id_user' => $id,
				]);
				$resultat = $req->fetch ();

				if($resultat) { //on renouvelle

					$selector = $resultat['selector'];
					$validator = bin2hex(random_bytes(30));
					
					setcookie(
						'rememberme',
						$selector.':'.base64_encode($validator),
						time() + 3600 * 24 * 30 * 2, //2 mois
						'/'
					);

					$req = $bdd->prepare ('UPDATE auth_tokens SET token=?, expires=? WHERE selector=?');
					$req->execute ([
						hash('sha256', $validator),
						date('Y-m-d\TH:i:s', time() + 3600 * 24 * 30 * 2),
						$selector
					]);
				} else { //on crée

					$selector = bin2hex(random_bytes(6)); //random seed de 12 bytes
					$validator = bin2hex(random_bytes(30));

					setcookie(
						'rememberme',
						$selector.':'.base64_encode($validator),
						time() + 3600 * 24 * 30 * 2, //2 mois
						'/'
					);

					$req = $bdd->prepare ('INSERT INTO auth_tokens (selector, token, id_user, expires) VALUES (?, ?, ?, ?)');
					$req->execute ([
						$selector,
						hash('sha256', $validator),
						$id,
						date('Y-m-d\TH:i:s', time() + 3600 * 24 * 30 * 2)
					]);


				}



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
