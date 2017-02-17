<?php
	require 'header.php';

	require 'CONTROLLERS/login_controller.php';

	require 'VIEWS/login_view.php';


?>
<script src="https://apis.google.com/js/platform.js"></script>
<script>
	function onSignInGoogle(gUser) {
		var id_token = gUser.getAuthResponse().id_token;
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'googleTokenSignin.php');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			window.location.replace("index.php");
		};
		xhr.send('idtoken=' + id_token);
	}
</script>

