<!DOCTYPE html>
<html>
<?php include 'includes/header.php';
include 'cardsinfo.php';

$id = $_GET['id'];
echo getInfo($id);
?>
</html>
