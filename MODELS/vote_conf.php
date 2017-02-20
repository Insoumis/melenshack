<?php
include ("includes/identifiants.php");
include_once ('includes/token.class.php');
include_once ("includes/constants.php");

function pointsTotauxUpdate($id_image) {

	try
	{
		$bdd = new PDO('mysql:host=' . DB_HOST . ';dbname='. DB_NAME .';charset=utf8', DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (PDOException $erreur) {
		echo 'Ce service est momentanément indisponible. Veuillez nous excuser pour la gêne occasionnée.';
	}
	


    $req = $bdd->prepare ('SELECT * FROM images WHERE id = :id_image');
    $req->execute ([
        ':id_image' => $id_image,
    ]);
    $resultat = $req->fetch ();
    
    $nb_vote_positif = $resultat["nb_vote_positif"];
    $nb_vote_negatif = $resultat["nb_vote_negatif"];
    $pointsTotaux = $nb_vote_positif - $nb_vote_negatif;

    $req = $bdd->prepare ('UPDATE images SET pointsTotaux = :pointsTotaux WHERE id = :id_image');
    $req->execute ([
        ':id_image' => $id_image,
        ':pointsTotaux' => $pointsTotaux,
    ]);
}
/*
if (!Token::verifier (3600, 'vote')) { // Penser à creer $token
    exit();
}

if (empty($_POST['id_image']) OR empty($_POST['vote']) OR !is_int($_POST['id_image']) OR !is_int($_POST['vote'])) {
    echo  'lol';
    exit();
}
A corriger/A faire
*/
if (!isset($_SESSION)) {
    session_start ();
}
if (!$_SESSION) {
    exit();
};
$id_user = $_SESSION['id'];
if (!$id_user) {
    // User non connecté
    exit();
};

$req = $bdd->prepare ('SELECT id FROM images WHERE id = :id_image ');
$req->execute ([
    ':id_image' => $_POST['id_image'],
]);
$resultat = $req->fetch ();

if (!$resultat) {
    //$_POST['id_image'] ne correpond pas à une image valide
    exit();
}

$req = $bdd->prepare ('SELECT * FROM vote WHERE id_image = :id_image AND id_user = :id_user');
$req->execute ([
    ':id_image' => $_POST['id_image'],
    ':id_user' => $id_user,
]);

$resultat = $req->fetch ();
$ancien_vote = $resultat["vote"];

if (!$resultat OR $resultat == null) // Si User n'a pas encore voté sur cette image
{
    $req = $bdd->prepare ('INSERT INTO vote(id_user, id_image, vote) VALUES(:id_user, :id_image, :vote)');
    $req->execute ([
        ':id_user' => $id_user,
        ':id_image' => $_POST['id_image'],
        ':vote' => $_POST['vote'], //-1 pour vote negatif, 1 pour vote positif
    ]);

    if ($_POST['vote'] == -1) {
        $req = $bdd->prepare ('UPDATE images SET nb_vote_negatif = nb_vote_negatif + 1  WHERE id = :id_image');
        $req->execute ([
            ':id_image' => $_POST['id_image'],
        ]);
        pointsTotauxUpdate($_POST['id_image']);
    } elseif ($_POST['vote'] == 1) {
        $req = $bdd->prepare ('UPDATE images SET nb_vote_positif = nb_vote_positif + 1  WHERE id = :id_image');
        $req->execute ([
            ':id_image' => $_POST['id_image'],
        ]);
        pointsTotauxUpdate($_POST['id_image']);
    }

} else { // Si user a déja voté sur cette image

    $req = $bdd->prepare ('UPDATE vote SET vote = :vote  WHERE id_image = :id_image AND id_user = :id_user ');
    $req->execute ([
        ':id_user' => $id_user,
        ':id_image' => $_POST['id_image'],
        ':vote' => $_POST['vote'], //-1 pour vote negatif, 1 pour vote positif
    ]);
    
    if ($_POST['vote'] == -1) {
        if ($ancien_vote == -1) {
            exit();
        } elseif ($ancien_vote == 1) {
            $req = $bdd->prepare ('UPDATE images SET nb_vote_negatif = nb_vote_negatif + 1,nb_vote_positif = nb_vote_positif - 1 WHERE id = :id_image');
            $req->execute ([
                ':id_image' => $_POST['id_image'],
            ]);
            pointsTotauxUpdate($_POST['id_image']);
        }
    } elseif ($_POST['vote'] == 1) {
        if ($ancien_vote == 1) {
            exit();
        } elseif ($ancien_vote == -1) {

            $req = $bdd->prepare ('UPDATE images SET nb_vote_positif = nb_vote_positif + 1,nb_vote_negatif = nb_vote_negatif - 1  WHERE id = :id_image');
            $req->execute ([
                ':id_image' => $_POST['id_image'],
            ]);
            pointsTotauxUpdate($_POST['id_image']);
        }
    }
}
?>
