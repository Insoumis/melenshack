<?php
include("includes/identifiants.php");
include_once('includes/securite.class.php');
include_once('includes/token.class.php');

if(Token::verifier(600, 'inscription')) 
{
  if(!empty($_POST['pseudo']) AND !empty($_POST['pass']) AND !empty($_POST['confpass']) AND !empty($_POST['email']))
  {
	$email = $_POST['email'];
	$pseudo = $_POST['pseudo'];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
	{
		$pass = Securite::bdd($_POST['pass']);
		$confpass = Securite::bdd($_POST['confpass']);

		$pass_hache = hash('sha256','testsalt'. $pass); // !! changer le salt pour le site !!
	    $confpass_hache = hash('sha256','testsalt' . $confpass); // !! changer le salt pour le site !!

		if ($pass_hache == $confpass_hache) 
		{
			$req = $bdd->prepare('SELECT id FROM users WHERE pseudo = :pseudo OR email = :email');
			$req->execute([
				'pseudo' => $pseudo,
				'email' => $email,
			]);
				
			$resultat = $req->fetch();
			if (!$resultat)
			{
			 // Insertion du message à l'aide d'une requête préparée
			 $req = $bdd->prepare('INSERT INTO users(pseudo, pass, email, dateinscription) VALUES(:pseudo, :pass, :email, CURDATE())');
					$req->execute([
								   ':pseudo' => htmlspecialchars($_POST['pseudo']),
								   ':pass' => htmlspecialchars($pass_hache),
								   ':email' => htmlspecialchars($email)
								   ]);
								   
						echo 'SUCCESS'; // Inscription réussi !
						
						$req = $bdd->prepare('SELECT id FROM users WHERE pseudo = :pseudo OR email = :email');
								$req->execute([
									'pseudo' => $pseudo,
									'email' => $email,
								]);
									
						$resultat = $req->fetch();
						if(!isset($_SESSION)){
						  session_start();
						}
						$_SESSION['id'] = $resultat['id'];
						$_SESSION['pseudo'] = $pseudo;
						
						header('Location:index.php');
			}
			else 
			{
			   // Doublon Pseudo ou email
			  header('Location:register.php?erreur=true');
			}
		}
		else 
		{
		  // Mauvais Mot de passe 
		  header('Location:register.php?erreur=true');
		}
	}
	else 
	{
	   // Mauvais email
	   header('Location:register.php?erreur=true');
	}
  } 
  else 
  {
 // Mauvais Mot de passe ou Login
	header('Location:register.php?erreur=true');
  }
}
else 
{
    //Mauvais Token
	header('Location:register.php?erreur=true');
}
?>
