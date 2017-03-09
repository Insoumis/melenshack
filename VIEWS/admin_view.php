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

		<h1>Page d'administration</h1>
		<ul>
			<li>
				<a href='index.php?sort=report'>Posts signalés</a>
			</li>
			<li>
				<a href='index.php?sort=deleted'>Posts supprimés</a>
			</li>
			<li>
				<form method="POST" action='MODELS/ban_conf.php'>
				Bannir un user :
				
				<input type="text" placeholder="pseudo" name="pseudo" />
				<input type="hidden" name="token" id="token" value="<?php echo $token_A?>">
				<input type="submit" value="Bannir">
				</form>
			</li>
			<li>
				<form method="POST" action='MODELS/promote_conf.php'>
				Promote un user :
				
				<input type="text" placeholder="pseudo" name="pseudo" />
				<input type="text" placeholder="grade" name="value" />
				<input type="hidden" name="token" id="token" value="<?php echo $token_A?>">
				<input type="submit" value="Promote">
				</form>
			</li>
		</ul>
			<?php if(!empty($listuser)): ?>
			<ul>
				<h3>Liste d'utilisateurs gradé</h3>
				<ol>
				<table border="1" cellspacing="10">
					<tr>
						<th> Pseudo </th>
						<th> Grade  </th>
					</tr>
					<?php echo $listuser; ?>
				</table>
				</ol>
			</ul>
			<?php endif ?>



	</div>
</body>
</html>
