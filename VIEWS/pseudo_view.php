<!DOCTYPE html>
<html>
<?php echo $HEAD ?>
	<body>
	<?php echo $NAVBAR ?>
	<div id="main_page">
	<form method="POST" action="MODELS/pseudo_conf.php">
	<?php if($fromregister): ?>
	<h1>Inscription réussie !</h1>
	<br>
	<h2>Malheureusement, le pseudo (nom affiché aux autres utilisateurs) "<?php echo $pseudo ?>" est déjà pris, merci d'en choisir un autre.</h2>
	
	<?php endif ?>
	<input type="text" placeholder="pseudo" name="pseudo">
	<input type="submit" value="Changer">
	</div>



	</form>








</body>
</html>
