<?php

if(!isset($_SESSION)) {
	session_start();
}
if (isset($_COOKIE['rememberme'])) { //supprime le cookie rememberme
	unset($_COOKIE['rememberme']);
	setcookie('rememberme', '', time() - 3600, '/');
}
if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])) {	//supprime la session
	session_destroy();
	header('Location:../index.php');
} else {
	header('HTTP/1.0 500 Internal Server Error');
}
