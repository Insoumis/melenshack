<?php

if(!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION['id']) && isset($_SESSION['pseudo'])) {	
	session_destroy();
	header('Location:../index.php');
} else {
	header('HTTP/1.0 500 Internal Server Error');
}
