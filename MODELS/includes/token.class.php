<?php
	class Token
	{
		//Cette fonction génère, sauvegarde et retourne un token
    	//On peut lui passer en paramètre optionnel un nom pour différencier les formulaires
		public static function generer($nom = '')
		{
			// On demarre une session
			if (!isset($_SESSION)) {
				session_start ();
			}
			
			$token = sha1(uniqid(mt_rand(), true)); // genere un token unique
			$_SESSION[$nom.'_token'] = $token;
			$_SESSION[$nom.'_token_time'] = time();
			
			return $token;
		} // exemple de l'utilisation du code : $token = Token::generer('inscription'); 
    /* Puis plus bas formulaire: <input type="hidden" name="token" id="token" value="<?php echo $token;?>"/> */


		/*  Cette fonction vérifie le token
			Passer en argument le temps de validité (en secondes)
			Le nom optionnel si défini lors de la création du token */
		public static function verifier($temps, $nom = '')
		{
			if (!isset($_SESSION)) {
				session_start ();
			}
			if(isset($_SESSION[$nom.'_token']) && isset($_SESSION[$nom.'_token_time']) && isset($_REQUEST['token']))
				if($_SESSION[$nom.'_token'] == $_REQUEST['token'])
					if($_SESSION[$nom.'_token_time'] >= (time() - $temps))
							return true;
			return false;
		}
	/* exemple du code: if(Token::verifier(600, 'inscription')) {TRAITEMENTS ..  ..} else{ERREUR} */
	}
?>
