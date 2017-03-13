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
		<div class="sub">Grade : <?php echo $grade ?></div>
		<a class="btn btn-warning btn-lg" href='index.php?sort=report'>Posts signalés</a><br><br>
		<a class="btn btn-danger btn-lg" href='index.php?sort=deleted'>Posts supprimés</a><br><br>
				<table class="form-group col-xs-6"><tr><td>
				
				<form class="form-group" method="POST" action='MODELS/ban_conf.php'>
				

				<label for="pseudo"><h4>(Dé)bannir un user :</h4></label>
				<input class="form-control" id="pseudo" type="text" placeholder="pseudo" name="pseudo" />
				<input type="hidden" name="token" id="token" value="<?php echo $token_A?>">
				
				<div class="radio">
				<label><input type="radio" name="value" value="1" checked> Bannir</label>
				<label><input type="radio" name="value" value="0"> Débannir</label><br>
				</div>

				<br><input class="btn btn-primary" type="submit" value="Bannir">
				</form></td><td style="padding: 20px">
				<form class="form-group" method="POST" action='MODELS/promote_conf.php'>
				<label for="pseudop"><h4>Promote un user :</h4></label>
				
				<input class="form-control" id="pseudop"type="text" placeholder="pseudo" name="pseudo" />
				<br><input class="form-control" type="number" max="<?php echo $grade ?>" min="0" placeholder="grade" name="value" />0: Peut seulement voter<br>1: Peut upload<br>2: peut upload en masse<br>3: modérateur<br>10: La caste<br>
				<input type="hidden" name="token" id="token" value="<?php echo $token_A?>">
				<br><input class="btn btn-primary" type="submit" value="Promote">
				</form></td></tr></table>

				<h3>Stats</h3>
				<p>Nombre d'utilisateurs inscrits : <?php echo $nbuser ?></p>
				<p>Nombre d'utilisateurs réseaux sociaux : <?php echo $nbfederated ?></p>
				<p>Nombre de posts : <?php echo $nbposts ?></p>
			<?php if(!empty($listuser)): ?>
				<h3>Liste des utilisateurs gradés</h3>
				<center>
				<table class="table-bordered table-hover" id="tableuser">
					<tr>
						<th> Pseudo </th>
						<th> Grade  </th>
					</tr>
					<?php echo $listuser; ?>
				</table>
				</center><br><br>
			<?php endif ?>


	</div>
	</div>
</body>
</html>
