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
	<div class="formAdmin">
		<h1>Page d'administration</h1>
		<div class="sub">Grade : <?php echo $grade ?></div><br><br>
		<a class="btn btn-warning btn-lg" href='index.php?sort=report'>Posts signalés</a><br><br>
		<a class="btn btn-danger btn-lg" href='index.php?sort=deleted'>Posts supprimés</a><br><br>
				<table class="form-group col-xs-6"><tr><td>
				<form class="form-group" method="POST" action='MODELS/ban_conf.php'>
				<label for="pseudo"><h4>Bannir un user :</h4></label>
				<input class="form-control" id="pseudo" type="text" placeholder="pseudo" name="pseudo" />
				<input type="hidden" name="token" id="token" value="<?php echo $token_A?>">
				<br><input class="btn btn-primary" type="submit" value="Bannir">
				</form></td><td style="padding: 20px">
				<form class="form-group" method="POST" action='MODELS/promote_conf.php'>
				<label for="pseudop"><h4>Promote un user :</h4></label>
				
				<input class="form-control" id="pseudop"type="text" placeholder="pseudo" name="pseudo" />
				<br><input class="form-control" type="number" max="<?php echo $grade ?>" min="0" placeholder="grade" name="value" />
				<input type="hidden" name="token" id="token" value="<?php echo $token_A?>">
				<br><input class="btn btn-primary" type="submit" value="Promote">
				</form></td></tr></table>
			<?php if(!empty($listuser)): ?>
				<h3>Liste des utilisateurs gradés</h3>
				<center>
				<table id="tableuser" border="1" cellspacing="10">
					<tr>
						<th> Pseudo </th>
						<th> Grade  </th>
					</tr>
					<?php echo $listuser; ?>
				</table>
				</center>
			<?php endif ?>


	</div>
	</div>
</body>
</html>
