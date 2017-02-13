<?php
	class Token
	{
		//Cette fonction génère, sauvegarde et retourne un token
    	//On peut lui passer en paramètre optionnel un nom pour différencier les formulaires
		public static function generer($nom = '')
		{
			// On demarre une session
<<<<<<< HEAD
		session_start();
        $token = sha1(uniqid(mt_rand(), true)); // genere un token unique
        $_SESSION[$nom.'_token'] = $token;
        $_SESSION[$nom.'_token_time'] = time();
=======
			session_start();
			
			$token = sha1(uniqid(mt_rand(), true)); // genere un token unique
			$_SESSION[$nom.'_token'] = $token;
			$_SESSION[$nom.'_token_time'] = time();
			
>>>>>>> d6a7ee673130f00484c0733fa2f9c93605af8c71
			return $token;
		} // exemple de l'utilisation du code : $token = Token::generer('inscription'); 
    /* Puis plus bas formulaire: <input type="hidden" name="token" id="token" value="<?php echo $token;?>"/> */


		/*  Cette fonction vérifie le token
			Passer en argument le temps de validité (en secondes)
			Le referer attendu (adresse absolue)
			Le nom optionnel si défini lors de la création du token */
		public static function verifier($temps, $nom = '')
		{
<<<<<<< HEAD
		session_start();
        if(isset($_SESSION[$nom.'_token']) && isset($_SESSION[$nom.'_token_time']) && isset($_POST['token']))
            if($_SESSION[$nom.'_token'] == $_POST['token']) 
                if($_SESSION[$nom.'_token_time'] >= (time() - $temps))
                        return true;
    return false;
=======
			session_start();
			if(isset($_SESSION[$nom.'_token']) && isset($_SESSION[$nom.'_token_time']) && isset($_POST['token']))
				if($_SESSION[$nom.'_token'] == $_POST['token']) 
					if($_SESSION[$nom.'_token_time'] >= (time() - $temps))
							return true;
			return false;
>>>>>>> d6a7ee673130f00484c0733fa2f9c93605af8c71
		}
	/* exemple du code: if(Token::verifier(600, 'inscription')) {TRAITEMENTS ..  ..} else{ERREUR} */
	}
?>
