<?php

define ('SALT_ID', 'testid'); 

define ('DB_HOST', 'localhost');
define ('DB_NAME', 'fimaj');
define ('DB_USER', 'root');
define ('DB_PASS', '');

define ('VIGNETTE_WIDTH', 800);
define ('VIGNETTE_HEIGHT', 800);

define ('MAX_SIZE' , 75000000); //en octet, pour upload (environ 7.5 Mo)
ini_set('memory_limit', '512M'); // Augmente la limite de mémoire PHP (corrige possibilité d'erreur lors d'upload d'image)

define ('PHP_DOSSIER_TMP', "C:/wamp64/tmp/");
?>
