<?php
include ("includes/identifiants.php");
include_once ('includes/securite.class.php');

$img = $_FILES['file'];

if (!isset($_SESSION)) {
    session_start ();
}
$id_user = $_SESSION['id'];
if (!$id_user) header ('Location:upload.php?erreur=true');

$captcha = $_POST['g-recaptcha-response'];
if (!$captcha) {
    header ('Location:upload.php?erreur=true');
    exit();
}
// Verification de la validité du captcha
$response = file_get_contents ("https://www.google.com/recaptcha/api/siteverify?secret=6LefaBUUAAAAAOCU1GRih8AW-4pMJkiRRKHBmPiE&response=" . $captcha);
$decoded_response = json_decode ($response);
if ($decoded_response->success == false) {
    header ('Location:upload.php?erreur=true');
    exit();
}

$max_size = 1000000;
if ($img['size'] > $max_size) {
    header ('HTTP/1.0 400 Bad Request');
    header ('Location:upload.php?erreur=true');
    exit();
}

$extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
$extension_image = strtolower (substr (strrchr ($img['name'], '.'), 1));
if (!in_array ($extension_image, $extensions_valides)) {
    header ('Location:upload.php?erreur=true');
    exit();
}

if (strlen($titre) > 255) {
    header ('Location:upload.php?erreur=true');
    exit();
}

$req = $bdd->prepare ('INSERT INTO images(titre, id_user, date_creation) VALUES(:titre, :id_user, CURDATE())');
$req->execute ([
    ':titre' => htmlspecialchars ($_POST['titre']),
    ':id_user' => $id_user,
]);

$id = $bdd->lastInsertId ();
$direction = '/images/' . $id . "." . $extension_image;
move_uploaded_file ($img['tmp_name'], __DIR__ . $direction);

header ('Location:view.php?id=' . $id);
?>
