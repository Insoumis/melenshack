<?php

require_once ('MODELS/includes/token.class.php');

$errmsg = "";

if (!isset($_SESSION)) {
    session_start ();
}
if (!$_SESSION) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}
if (!isset($_SESSION['id']) || $grade < 1) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}
$id_user = $_SESSION['id'];

