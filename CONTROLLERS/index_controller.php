<?php

require_once 'MODELS/check_grade.php';

$showSupprime = false;
if(isset($grade) && $grade > 0)
	$showSupprime = true;
