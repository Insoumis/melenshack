<html>
<body>
<?php

require_once 'includes/vendor/autoload.php';
require_once 'includes/identifiants.php';

use Abraham\TwitterOAuth\TwitterOAuth;

if(!isset($_SESSION))
	session_start();

//charge les clés de l'app
$creds = json_decode(file_get_contents("../../twitter_credentials.json"), true);



if(isset($_GET['request'])) {

	$connection = new TwitterOAuth($creds['consumer_key'], $creds['consumer_secret']);
	$callback = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).$creds['oauth_callback'];
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => $callback));

	if($request_token) {
		$token = $request_token['oauth_token'];
		$_SESSION['oauth_token'] = $token ;
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

		$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
		header("Location: $url");
	} else {
		echo "<input id='result' value='error' hidden>";
	}

} else if(isset($_GET['oauth_token'])) {

	if($_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
		echo "<input id='result' value='error' hidden>";
	}

	$connection = new TwitterOAuth($creds['consumer_key'], $creds['consumer_secret'], $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);

	if($access_token) {
		$connection = new TwitterOAuth($creds['consumer_key'], $creds['consumer_secret'], $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$content = $connection->get('account/verify_credentials');


		$content = json_decode(json_encode($content), true);
		$id = $content['id'];
		$name = $content['screen_name'];
		if($content['default_profile_image'])
			$picture = null;
		else
			$picture = $content['profile_image_url'];

		if(array_key_exists('email')) {
			$email = $content['email'];
		} else
			$email = null;

		//vérifie si l'user est déjà inscrit
		$req = $bdd->prepare("SELECT id_user FROM federated_users WHERE oauth_provider='twitter' AND oauth_uid=?");
		$req->execute([
			$id,
		]);
		$res = $req->fetch();

		if($res) { //deja inscrit
			//on update les infos
			$id_user = $res['id_user'];
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
			echo "<input id='result' value='success' hidden>";

		} else { //on l'inscrit
			$req = $bdd->prepare('INSERT INTO users(dateinscription) VALUES(NOW());');
			$req->execute();

			$id_user = $bdd->lastInsertId();


			$req = $bdd->prepare("INSERT INTO federated_users(id_user, oauth_provider, oauth_uid, name, email, picture) VALUES(:id_user,'twitter', :oauth_uid, :name, :email, :picture)");

			$req->execute([
				':id_user' => $id_user,
				':oauth_uid' => $id,
				':name' => $name,
				':email' => $email,
				':picture' => $picture,
			]);

			$_SESSION['id'] = $id_user;
			$_SESSION['type'] = 'twitter';
			echo "<input id='result' value='redirect' hidden>";


		}


	}

} else {
	echo "<input id='result' value='error' hidden>";
}
?>

<script>
window.onload = function() {
	try {
		window.opener.onTwitterClose(document.getElementById('result').value);
	}
	catch (err) {}
		window.close();
	return false;
};
</script>

</body>
</html>
