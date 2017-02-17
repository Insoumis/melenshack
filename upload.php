<?php

require 'header.php';

require 'CONTROLLERS/upload_controller.php';

require 'VIEWS/upload_view.php';

?>

<script src='https://www.google.com/recaptcha/api.js'></script>
<script>

var captchaChecked = false;
var image = false;

function recaptchaCallback() {
	captchaChecked = true;
	checkSubmit();
}

function readURL(input) {
	if(input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			if(input.files[0].size > $("#max").val()) {
				alert("Fichier trop lourd !");
				return;
			}
			$("#preview").attr("src", e.target.result).width(800);
			image = true;
			checkSubmit();
		}

		reader.readAsDataURL(input.files[0]);
	} else {
		image = false;
	}
}

$("#file").change(function() {
	readURL(this);
});

$("#titre").on('input', function() {
	checkSubmit();
});

function checkSubmit() {
	if(image && captchaChecked && $("#titre").val()) {
		$("#submit").prop("disabled", false);	
	}
}

</script>

