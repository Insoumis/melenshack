<?php

define ('SALT_ID', 'IdquicodeToutseul');

define ('DB_HOST', 'localhost');
define ('DB_NAME', 'melenshack');
define ('DB_USER', 'melenshack');
define ('DB_PASS', 'W6D#x2^fNQp}DFbn');

define ('VIGNETTE_WIDTH', 800);
define ('VIGNETTE_HEIGHT', 800);

define ('MAX_SIZE' , 7800000); //en octet, pour upload (environ 7.5 Mo)
ini_set('memory_limit', '512M'); // Augmente la limite de mémoire PHP (corrige possibilité d'erreur lors d'upload d'image)

define ('PHP_DOSSIER_TMP', "/tmp");
define ('SITE_DOMAINE', "http://melenshack.fr");

?>
