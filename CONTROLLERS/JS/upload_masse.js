
var captchaChecked = false;
var image = false;

function recaptchaCallback() {
	captchaChecked = true;
}

function readURL(input) {
	if(input.files) {
		for (var f=0; f < input.files.length; f++) {
			if(f >= input.files.length)
				break;

			counter = 0;

			var t = input.files[f].type;
			if(!(t == "image/gif" || t == "image/png" || t == "image/jpg" || t == "image/jpeg" || t == "image/bmp")) {
				alert("L'image "+ input.files[f].name+" n'est pas valide !");
				continue;
			}

			var file = input.files[f];
			if(file.size > $("#max").val()) {
				alert("Fichier trop lourd : "+file.name);
				return;
			}
			image = true;
			e = $("<span title='Ciquez pour supprimer'><br><span class='glyphicon glyphicon-ok'></span class='namestr'>"+file.name+"</span>").click(function() {
					$(this).remove();

					});

			$('#name').append(e);
			$('#errorContainer').hide();
			$('#nameContainer').show();
			$("#drop").css('border', '3px dashed green')	
				.css('background', 'white');
		}
	} else if(input) {
		var x = document.getElementById("url").value;
		$("#preview").attr("src", x).width(800);
		image = true;
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

$("#drop").click(function(e) {
		$("#filelabel").click();
		e.stopPropagation();
		});

$('#tagsinput').tagsinput({
maxTags: 10,
maxChars: 20,
trimValue: true
});
