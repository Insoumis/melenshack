
var captchaChecked = false;
var image = false;

function recaptchaCallback() {
		captchaChecked = true;
		checkSubmit();
}

function readURL(input) {
		if(input.files && input.files[0]) {
				var reader = new FileReader();
				counter = 0;
				reader.onload = function(e) {
						if(input.files[0].size > $("#max").val()) {
								alert("Fichier trop lourd !");
								return;
						}
						image = true;
						$('#name').html(input.files[0].name);
						$('#errorContainer').hide();
						$('#nameContainer').show();
						$("#drop").css('border', '3px dashed green')	
						.css('background', 'white');
						checkSubmit();
				}
				var t = input.files[0].type;
				if(t == "image/gif" || t == "image/png" || t == "image/jpg" || t == "image/jpeg" || t == "image/bmp")
					reader.readAsDataURL(input.files[0]);
				else {
					$('#error').html("Format invalide !");
					$('#nameContainer').hide();
					$('#errorContainer').show();
					$("#drop").css('border', '3px dashed red')	
					.css('background', 'white');

				}
		} else if(input) {
				var x = document.getElementById("url").value;
				$("#preview").attr("src", x).width(800);
				image = true;
				checkSubmit();
		}
		else {
				image = false;
		}
}


var counter = 0;
$(document).on('dragenter', '#drop', function() {
		counter ++;
		$(this).css('border', '3px dashed #23b9d0');	
		$(this).css('background', 'white');
		return false;
});

$(document).on('dragover', '#drop', function(e){
		e.preventDefault();
		e.stopPropagation();
		$(this).css('border', '3px dashed #23b9d0');
		$(this).css('background', 'white');
		return false;
});

$(document).on('dragleave', '#drop', function(e) {
		e.preventDefault();
		e.stopPropagation();
		counter --;
		if(counter == 0) {
			$(this).css('border', '3px dashed grey');
			$(this).css('background', '');
		}
		return false;
});


$(document).on('drop', '#drop', function(e) {
		counter = 0;

		if(e.originalEvent.dataTransfer){
				if(e.originalEvent.dataTransfer.files.length) {
						// Stop the propagation of the event
						e.preventDefault();
						e.stopPropagation();
						$(this).css('border', '3px dashed green');
						// Main function to upload
						$("#file").prop("files", e.originalEvent.dataTransfer.files).change();
				} else {
					$('#error').html("Veuillez glisser un fichier !");
					$('#nameContainer').hide();
					$('#errorContainer').show();
					$("#drop").css('border', '3px dashed red')	
					.css('background', 'white');
				}
		}
		else {
			$('#error').html("Veuillez glisser un fichier !");
			$('#nameContainer').hide();
			$('#errorContainer').show();
			$("#drop").css('border', '3px dashed red')	
			.css('background', 'white');
		}
		return false;
});




$("#file").change(function() {
		readURL(this);
});

$("#url").change(function() {
		readURL(this);
});

$("#titre").on('input', function() {
		checkSubmit();
});

$("#drop").click(function() {
	$("#filelabel").click();
});

function checkSubmit() {
		if(captchaChecked && $("#titre").val()) {
				$("#submit").prop("disabled", false);	
		}
}

$('#tagsinput').tagsinput({
	  maxTags: 10,
	  maxChars: 20,
	  trimValue: true
});
$('#tagsinput').on('beforeItemAdd', function(e) {
	e.item = "#" + e.item;
	$(this).tagsinput("refresh");
});
