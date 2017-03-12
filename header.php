<?php

include 'MODELS/auth_cookie.php';

$protocol = 'https://';

checkCookie();

ob_start();

require 'head.php';

$HEAD = ob_get_clean();

ob_start();

require 'CONTROLLERS/navbar_controller.php';
require 'VIEWS/navbar_view.php';

$NAVBAR = ob_get_clean();


