<?php

include 'MODELS/auth_cookie.php';

$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';

checkCookie();

ob_start();

require 'head.php';

$HEAD = ob_get_clean();

ob_start();

require 'CONTROLLERS/navbar_controller.php';
require 'VIEWS/navbar_view.php';

$NAVBAR = ob_get_clean();


