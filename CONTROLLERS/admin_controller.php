<?php

include 'MODELS/check_grade.php';

if (!isset($_SESSION)) {
    session_start ();
}
if (!$_SESSION) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}
$id_user = $_SESSION['id'];
if (!$id_user || $grade < 1) {
    header("HTTP/1.0 403 Forbidden");
    exit();
}

