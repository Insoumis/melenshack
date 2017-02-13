<?php

$captcha = $_POST['g-recaptcha-response'];

//verifie le captcha via l api google
$url = 'https://www.google.com/recaptcha/api/siteverify';
$vars = 'secret=6LefaBUUAAAAAOCU1GRih8AW-4pMJkiRRKHBmPiE&response=' . $captcha;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = json_decode(curl_exec($ch));
if(!$response->success) {
        header('HTTP/1.0 400 Bad Request');
        exit();
}

$max_size = 1000000;
$img = $_FILES['file'];
if($img['size'] > $max_size) {
        header('HTTP/1.0 400 Bad Request');
	exit();
}
echo $img['name'];

?>
