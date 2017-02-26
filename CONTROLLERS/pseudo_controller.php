<?php

$fromregister = false;
$pseudo = "";
if(!empty($_GET['erreur']) && $_GET['erreur'] == 'fromregister') {
	$fromregister = true;

	if(!empty($_GET['pseudo'])) {
		$pseudo = rawurldecode($_GET['pseudo']);
	}
}
