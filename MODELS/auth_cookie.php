<?php

include_once("includes/identifiants.php");
include_once ("includes/constants.php");
include_once ("includes/random/random.php");

if (!isset($_SESSION)) {
	session_start ();
}

function checkCookie() {
	if(empty($_SESSION['id']) && !empty($_COOKIE['rememberme'])) {

		global $bdd;

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
			if($resultat['pseudo'])
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
}


function createCookie($id) {
	global $bdd;

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
