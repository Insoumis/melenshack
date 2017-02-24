<?php

include_once("includes/identifiants.php");
include_once('includes/securite.class.php');
include_once ("includes/constants.php");

if (!isset($_SESSION)) {
	session_start ();
}
if(empty($_SESSION['id']) && !empty($_COOKIE['rememberme'])) {

	list($selector, $validator) = explode(':', $_COOKIE['rememberme']);

	$req = $bdd->prepare('SELECT * FROM auth_tokens WHERE (selector = :selector AND expires > NOW())');
	$req->execute([
		':selector' => $selector,
	]);

	$resultat = $req->fetch();

	if($resultat && hash_equals($resultat['token'], hash('sha256', base64_decode($validator)))) {

		$req = $bdd->prepare('SELECT * FROM users WHERE id=:id_user');
		$req->execute([
			':id_user' => $resultat['id_user'],
		]);

		$resultat = $req->fetch();

		$_SESSION['id'] = $resultat['id'];
		$_SESSION['pseudo'] = $resultat['pseudo'];



		//on renouvelle le cookie
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

		return;

	}
}
