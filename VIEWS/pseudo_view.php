<!DOCTYPE html>
<html>
<?php echo $HEAD ?>
	<body>
	<?php echo $NAVBAR ?>
	<div id="main_page">
	<?php if(!empty($errmsg)): ?>
			<div class='alert alert-danger erreur'>
				<a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
				<?php echo $errmsg ?>
			</div>
			<?php endif ?>


	<?php if($showPage): ?>
	<form method="POST" action="MODELS/pseudo_conf.php" id="pseudoForm">
	<?php if($fromregister): ?>
		<div class='alert alert-success erreur'>
				<a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
				Inscription réussie ! Malheureusement, le pseudo <strong><?php echo $pseudo ?></strong> est déjà pris !
			</div>

	<?php endif ?>

	<h1>Changer mon pseudo</h1>
	<div class="sub">Votre pseudo est votre nom visible par les autres utilisateurs</div>
	<br><br>
	<div class="form-group col-xs-4">
		<label for="pseudo">Nouveau pseudo</label>
		<br>
		<input class="form-control input-lg" id="pseudo" type="text" placeholder="Nouveau pseudo" name="pseudo">
		<br>
		<input type="submit" value="Changer" class="btn btn-primary btn-lg">
	</div>
	</div>



	</form>
	<?php endif ?>







</body>
</html>
