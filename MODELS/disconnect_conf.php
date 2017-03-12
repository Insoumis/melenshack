<?php

if(!isset($_SESSION)) {
	session_start();
}
if (isset($_COOKIE['rememberme'])) { //supprime le cookie rememberme
	unset($_COOKIE['rememberme']);
	setcookie('rememberme', '', time() - 3600, '/');
}

session_destroy();
header("Location:../index.php");
