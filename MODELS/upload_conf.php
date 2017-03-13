<?php
include_once ("includes/constants.php");
require_once ('includes/token.class.php');
include_once ("includes/GIFDecoders.class.php");
include_once ("includes/identifiants.php");
include_once ('includes/securite.class.php');
include_once ('upload_functions.php');
include_once 'check_grade.php';
/*
ERREURS RETOURNEES:
notlogged
captcha
size
format
titre
pseudo
grade
token
*/
if (!isset($_SESSION)) {
    session_start ();
}
$id_user = $_SESSION['id'];
if (!$id_user) header ('Location:../upload.php?erreur=notlogged');

$pseudo = $_SESSION['pseudo'];
if (!$pseudo) header ('Location:../upload.php?erreur=pseudo');

if((Token::verifier(3600, 'upload')) == false) {
    header ('Location:../upload.php?erreur=token');
    exit();
}
/*
$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domaine= parse_url(SITE_DOMAINE, PHP_URL_HOST);
echo $referer.'</br>';
echo $domaine.'</br>';
if ($referer != $domaine) {
    header ('Location:../upload.php?erreur=referer');
    exit();
    echo'lol';
} */



$captcha = $_POST['g-recaptcha-response'];
if (!$captcha) {

	    header ('Location:../upload.php?erreur=captcha');
		    exit();
}

// Verification de la validité du captcha
$response = file_get_contents ("https://www.google.com/recaptcha/api/siteverify?secret=6LefaBUUAAAAAOCU1GRih8AW-4pMJkiRRKHBmPiE&response=" . $captcha);
$decoded_response = json_decode ($response);
if ($decoded_response->success == false) {

	    header ('Location:../upload.php?erreur=captcha');
		    exit();
}




$req = $bdd->prepare ('SELECT grade FROM users WHERE id = :id_user');
$req->execute ([
    'id_user' => $id_user,
]);
$grade = $req->fetch ()['grade'];
if($grade < 1) {
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
    header ('Location:../upload.php?erreur=banned');
    exit();
}

$titre = htmlspecialchars($_POST['titre']);
if (strlen ($titre) > 255) {
    header ('Location:../upload.php?erreur=titre');
    exit();
}

if (isset($_POST['pseudo'])) {
    $pseudoAuthor = htmlspecialchars ($_POST['pseudo']);
    if (strlen ($pseudoAuthor) > 255 || strlen ($pseudoAuthor) == 0) {
        header ('Location:../upload.php?erreur=pseudo');
        exit();
    }
    if ($pseudo != $pseudoAuthor) {
        $pseudo = $pseudoAuthor;
    }
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
        header ('Location:../upload.php?erreur=tags');
        exit();
    }
} else {
    $tagsstr = "";
}
if (!empty($_POST['url'])) {
    $url = htmlspecialchars ($_POST['url']);
    $res = insertImageFromUrl($url, $id_user, $titre, $tagsstr,$pseudo);
    if(strpos($res, '?erreur=') !== false) {
        header("Location:../upload.php$res");
        exit();
    }
    $id = $res;
    $res = createImagesVignettes($_FILES['file'], $id, true);
} elseif (!empty($_POST['url']) AND !empty($_FILES['file'])) {
    header ('Location:../upload.php?erreur='); // Soit url, soit image, pas les 2 en meme temps
    exit();
} else {
    if (empty($_FILES['file'])) {
        header ('Location:../upload.php?erreur=image'); //pas d'image
        exit();
    }
    $res = insertImageFromFile($_FILES['file'], $id_user, $titre, $tagsstr, $pseudo);
    if(strpos($res, '?erreur=') !== false) {
        header("Location:../upload.php$res");
        exit();
    }
    $id = $res;
    $res = createImagesVignettes($_FILES['file'], $id);
}
if($res == "redirect")
    header ('Location:../view.php?id=' . $id);
else
    header ('Location:../upload.php'.$res);
