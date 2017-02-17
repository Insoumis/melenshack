<?php

require 'header.php';

require 'CONTROLLERS/register_controller.php';

require 'VIEWS/register_view.php';

?>

<script src='https://www.google.com/recaptcha/api.js'></script>
<script>

function recaptchaCallback() {
	$("#submit").prop("disabled", false);
}

</script>
