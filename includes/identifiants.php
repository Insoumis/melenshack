<?php
$NomServeur = $_SERVER['SERVER_NAME'] ; 
$local = ( (substr($NomServeur, 0, 7) == '192.168') || ($NomServeur == 'localhost') || (substr($NomServeur, 0, 3) == '127') );
$verbose = $local;
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=fimaj;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (PDOException $erreur) {
    if ($verbose) {
        echo 'Erreur : '.$erreur->getMessage();
    } else {
        echo 'Ce service est momentanément indisponible. Veuillez nous excuser pour la gêne occasionnée.';
    }
}

?>
