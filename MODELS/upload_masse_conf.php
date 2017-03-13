<?php

set_time_limit(3600);


include_once ("includes/constants.php");
require_once ('includes/token.class.php');
include_once ("includes/GIFDecoders.class.php");
include_once ("includes/identifiants.php");
include_once ('includes/securite.class.php');
include_once ('upload_functions.php');
include_once 'check_grade.php';

function reArrayFiles(&$file_post) {


	$file_ary = array();
	$file_count = count($file_post['name']);
	$file_keys = array_keys($file_post);

	for ($i=0; $i<$file_count; $i++) {

		foreach ($file_keys as $key) {

			$file_ary[$i][$key] = $file_post[$key][$i];
		}
	}

	return $file_ary;
}


if (!isset($_SESSION)) {
	session_start ();
}

$id_user = $_SESSION['id'];
if (!$id_user) header ('Location:../upload_masse.php?erreur=notlogged');

$pseudo = $_SESSION['pseudo'];
if (!$pseudo) header ('Location:../upload_masse.php?erreur=pseudo');

/*
   $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
   $domaine= parse_url(SITE_DOMAINE, PHP_URL_HOST);
   echo $referer.'</br>';
   echo $domaine.'</br>';
   if ($referer != $domaine) {
   header ('Location:../upload_masse.php?erreur=referer');
   exit();
   echo'lol';
   } */


$req = $bdd->prepare ('SELECT grade FROM users WHERE id = :id_user');
$req->execute ([
		'id_user' => $id_user,
]);
$grade = $req->fetch ()['grade'];

if($grade < 2) {
	header("Location:../upload?erreur=grade");
	exit();
}


$req = $bdd->prepare ('SELECT id FROM ban WHERE id_user = :id_user');
$req->execute ([
		'id_user' => $id_user,
]);
$resultat = $req->fetch ();

if ($resultat) {
	//La marteau du ban a frappé :)
	header ('Location:../upload_masse.php?erreur=banned');
	exit();
}


$titre = htmlspecialchars($_POST['titre']);
if (strlen ($titre) > 255){
	header ('Location:../upload_masse.php?erreur=titre');
	exit();
}
if (!empty($_POST['pseudo']) && $grade >= 5) {
	$pseudoAuthor = htmlspecialchars ($_POST['pseudo']);
	if (strlen ($pseudoAuthor) > 255) {
		header ('Location:../upload.php?erreur=pseudo');
		exit();
	}
	if ($pseudo != $pseudoAuthor) {
		$pseudo = $pseudoAuthor;
	}
} else {
	$pseudo = $_SESSION['pseudo'];
}

if (!empty($_POST['tags'])) {
	$nb_id = 0;
	$tagsstr = "";

	foreach ($_POST['tags'] as $id => $tag) {
		if ($id == 0) {
			$tagsstr = htmlspecialchars ($tag);
		} else
			$tagsstr = $tagsstr . ',' . htmlspecialchars ($tag);
		$nb_id = $id;
	}

	$nbtags = $nb_id + 1;

	if ($nbtags > 10 OR strlen ($tagsstr) > 255) {
		header ('Location:../upload_masse.php?erreur=tags');
		exit();
	}
} else {
	$tagsstr = "";
}

if(!empty($_FILES['file'])) {
	$arr = reArrayFiles($_FILES['file']);
	foreach($arr as $f) {
		if(empty($f['name']))
			continue;
		$res = insertImageFromFile($f, $id_user, $titre, $tagsstr, $pseudo);
		if(strpos($res, '?erreur=') !== false) {
			header("Location:../upload_masse.php$res");
			exit();
		}
		$id = $res;
		$res = createImagesVignettes($f, $id); 
		if(strpos($res, '?erreur=') !== false) {
			header("Location:../upload_masse.php$res");
			exit();
		}

	}
}

if(!empty($_POST['url'])) {
	$urls = explode("\n", trim($_POST['url']));

	foreach($urls as $u) {
		$res = insertImageFromUrl(trim($u), $id_user, $titre, $tagsstr, $pseudo);
		if(strpos($res, '?erreur=') !== false) {
			header("Location:../upload_masse.php$res");
			exit();
		}
		$id = $res;
		$res = createImagesVignettes($_FILES['file'], $id, true); 
		if(strpos($res, '?erreur=') !== false) {
			header("Location:../upload_masse.php$res");
			exit();
		}

	}	
}

header("Location: ../index.php?sort=new&pseudo=".$_SESSION['pseudo']);
