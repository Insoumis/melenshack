<script>
$("nav").ready(function() {

	//fix bug popover mobile
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		$('#decoli>img').attr('data-placement', 'left');
	}
	var useropened = false;

	$('#decoli>img').hover(function() {
		$(this).attr('src', 'assets/phi_blanc.png');
		$(this).parent().stop(true,false).animate({'background-color':'#d9534f', 'borderColor':'#23b9d0'}, 200);
	}, function() {
		if(!useropened) {
			$(this).attr('src', 'assets/phi.png');	
			$(this).parent().stop(true,false).animate({'background-color':'', 'borderColor':'#e23d22'}, 200);
		}
	});

	$(document).click(function() {
		useropened = false;
		$("#decoli>img").attr('src', 'assets/phi.png')
			.parent().stop(true,false).animate({'background-color':'', 'borderColor':'#e23d22'}, 200);
		$("#decoli>img").popover('hide');
	});
	$('#decoli>img').click(function(e) {
		useropened = !useropened;
		e.stopPropagation();
		if(!useropened) {
			$(this).attr('src', 'assets/phi.png');	
			$(this).parent().stop(true,false).animate({'background-color':'', 'borderColor':'#e23d22'}, 200);
		} else {
			
			$(this).attr('src', 'assets/phi_blanc.png');
			$(this).parent().stop(true,false).animate({'background-color':'#d9534f', 'borderColor':'#23b9d0'}, 200);
		}

	});

	$('body').on('hidden.bs.popover', function (e) {
		$(e.target).data("bs.popover").inState.click = false;
	});

	$('#searchinput').click(function(e) {e.stopPropagation();});
	$('#searchinput .popover input').click(function(e) {e.stopPropagation();});

	$('[data-toggle="popover"]').popover();
});
</script>


<?php
$grade = 0;
require 'MODELS/check_grade.php';


if(!isset($_SESSION))
	session_start();

$connexionButton = true;
$id_user = "";

if(isset($_SESSION['id'])) {
	$connexionButton = false;
	$id_user = $_SESSION['id'];
}

$sort = "hot";
if(isset($_GET['sort']))
	$sort = $_GET['sort'];

if(isset($_SESSION['pseudo']))
	$pseudo = $_SESSION['pseudo'];
else
	$pseudo = "Anonyme";
$baseName= basename($_SERVER['PHP_SELF']);

$isHotActive = false;
$isNewActive = false;
$isRandomActive = false;

$showSearch = false;
if($baseName == "index.php")
	$showSearch = true;

if($baseName == "index.php" && $sort == "new")
	$isNewActive = true;
else if($baseName == "index.php" && $sort == "random")
	$isRandomActive = true;
else if($baseName == "index.php" && $sort == "hot")
	$isHotActive = true;

