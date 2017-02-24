<?php

require_once 'includes/vendor/autoload.php';
require_once 'includes/identifiants.php';

if(!isset($_SESSION))
	session_start();

//charge les clés de l'app
$creds = json_decode(file_get_contents("../../facebook_credentials.json"), true);

//initialise l'objet
$fb = new Facebook\Facebook([
	'app_id' => $creds['app_id'],
	'app_secret' => $creds['app_secret'],
	'default_graph_version' => 'v2.5',
]);

//permet de récupérer l'accessToken depuis le cookie créé par le SDK JS
$jsHelper = $fb->getJavaScriptHelper();
try {
	$accessToken = $jsHelper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo "error";
	exit();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo "error";
	exit();
}

if (isset($accessToken)) {

	//requete graphAPI pour récupérer les infos
	$request = $fb->request('GET', '/me?fields=id,name,email,gender,picture');
	$request->setAccessToken($accessToken);
	try {
		$response = $fb->getClient()->sendRequest($request);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo "error";
		exit();
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo "error";
		exit();
	}

	if(isset($response)) {
		$gn = $response->getGraphNode();

		$id = $gn['id'];
		$name = $gn['name'];
		$gender = $gn['gender'];
		if(property_exists($gn, 'email')) //vérifie si l'user a donné la permission et si l'email est vérifié
			$email = $gn['email'];
		else
			$email = null;

		
		if(!$gn['picture']['is_silhouette'])
			$picture = $gn['picture']['url'];
		else
			$picture = null;

		//vérifie si l'user est déjà inscrit
		$req = $bdd->prepare("SELECT id_user FROM federated_users WHERE oauth_provider='facebook' AND oauth_uid=?");
		$req->execute([
			$id,
		]);
		$res = $req->fetch();

		if($res) { //deja inscrit
			//on update les infos
			$id_user = $res['id_user'];
			$req = $bdd->prepare("UPDATE federated_users SET name=:name, gender=:gender, email=:email, picture=:picture WHERE id_user=:id_user");
			$req->execute([
				':id_user' => $id_user,
				':name' => $name,
				':gender' => $gender,
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
			$_SESSION['type'] = 'facebook';
			echo "success";
			exit();

		} else { //on l'inscrit
			$req = $bdd->prepare('INSERT INTO users(dateinscription) VALUES(NOW());');
			$req->execute();

			$id_user = $bdd->lastInsertId();


			$req = $bdd->prepare("INSERT INTO federated_users(id_user, oauth_provider, oauth_uid, name, gender, email, picture) VALUES(:id_user,'facebook', :oauth_uid, :name, :gender, :email, :picture)");
			
			$req->execute([
				':id_user' => $id_user,
				':oauth_uid' => $id,
				':name' => $name,
				':gender' => $gender,
				':email' => $email,
				':picture' => $picture,
			]);

			$_SESSION['id'] = $id_user;
			$_SESSION['type'] = 'facebook';
			echo "redirect";
			exit();

	
		}
	}

}
