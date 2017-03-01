<?php

define ('SALT_ID', 'testid'); 

define ('DB_HOST', 'localhost');
define ('DB_NAME', 'fimaj');
define ('DB_USER', 'root');
define ('DB_PASS', '');

define ('VIGNETTE_WIDTH', 1000);
define ('VIGNETTE_HEIGHT', 1000);

define ('MAX_SIZE' , 10000000); //en octet, pour upload
ini_set('memory_limit', '512M'); // Augmente la limite de mémoire PHP (corrige possibilité d'erreur lors d'upload d'image)

define ('PHP_DOSSIER_TMP', "C:/wamp64/tmp/");
?>
