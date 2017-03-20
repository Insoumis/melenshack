<?php

require_once 'includes/vendor/autoload.php';
require_once 'includes/identifiants.php';
include_once("auth_cookie.php");

if(!isset($_SESSION))
	session_start();

if(!isset($_POST['idtoken']))
	exit();

$idtoken = $_POST['idtoken'];

$client = new Google_Client();
$client->setAuthConfigFile('../../google_credentials.json');

$payload = $client->verifyIdToken($idtoken);

if(!$payload) {
	echo "error";
	exit();
}

$id = $payload['sub'];
$email = $payload['email'];
$name = $payload['name'];
$picture = $payload['picture'];

//vérifie si l'user est déjà inscrit
$req = $bdd->prepare("SELECT id_user FROM federated_users WHERE oauth_provider='google' AND oauth_uid=?");
$req->execute([
	$id,
]);
$res = $req->fetch();

if($res) { //deja inscrit
	//on update les infos
	$id_user = $res['id_user'];

	$req = $bdd->prepare ('SELECT id FROM ban WHERE id_user = :id_user');
	$req->execute ([
		'id_user' => $id_user,
	]);
	$resultat = $req->fetch ();

	if ($resultat) {
		//La marteau du ban a frappé :)
		echo "banni";
		exit();
	}

	$req = $bdd->prepare("UPDATE federated_users SET name=:name, email=:email, picture=:picture WHERE id_user=:id_user");
	$req->execute([
		':id_user' => $id_user,
		':name' => $name,
		':email' => $email,
		':picture' => $picture,
	]);

	$req = $bdd->prepare("SELECT pseudo FROM users WHERE id=:id_user");
	$req->execute([
		':id_user' => $id_user,
	]);
	$res = $req->fetch();
	$pseudo = $res['pseudo'];

	if($pseudo)
		$_SESSION['pseudo'] = $pseudo;

	$_SESSION['id'] = $id_user;
	$_SESSION['type'] = 'google';
	echo "success";
	exit();

} else { //on l'inscrit
	$req = $bdd->prepare('INSERT INTO users(dateinscription) VALUES(NOW());');
	$req->execute();

	$id_user = $bdd->lastInsertId();


	$req = $bdd->prepare("INSERT INTO federated_users(id_user, oauth_provider, oauth_uid, name, email, picture) VALUES(:id_user,'google', :oauth_uid, :name, :email, :picture)");

	$req->execute([
		':id_user' => $id_user,
		':oauth_uid' => $id,
		':name' => $name,
		':email' => $email,
		':picture' => $picture,
	]);

	$_SESSION['id'] = $id_user;
	$_SESSION['type'] = 'google';

	createCookie($id_user);

	//vérifie si pseudo déja pris
	$req = $bdd->prepare("SELECT * FROM users WHERE pseudo=:pseudo");
	$req->execute([
		':pseudo' => $name
	]);
	$res = $req->fetch();

	if($res) { //pseudo deja pris, user doit le changer
		echo "&pseudo=".urlencode($name);
		exit();
	}

	$req = $bdd->prepare("UPDATE users SET pseudo=:pseudo WHERE id=:id");
	$req->execute([
		':pseudo' => $name,
		':id' => $id_user
	]);


	$_SESSION['pseudo'] = $name;

	echo "success";
	exit();

}
