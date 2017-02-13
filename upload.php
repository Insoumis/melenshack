<?php
$max_size = 10000000;
$img = $_FILES['file'];
$titre = $_POST['titre'];
if($img['size'] > $max_size) {
	echo "Fichier trop lourd !";
	exit();
}
$detectedType = exif_imagetype($img['tmp_name']);
if($detectedType == 1)
	$ext = ".gif";
else if($detectedType == 2)
	$ext = ".jpeg";
else if($detectedType == 3)
	$ext = ".png";
else {
	echo "Le fichier doit etre une image PNG, JPEG ou GIF !";
	exit();
}
echo $img['name'];

$filename = microtime() . "$ext";
$uploadfile = "/home/alexandre/" . "$filename";

echo $uploadfile;
if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    echo "Le fichier est valide, et a été téléchargé
           avec succès. Voici plus d'informations :\n";
} else {
    echo "Attaque potentielle par téléchargement de fichiers.
          Voici plus d'informations :";
}

?>
