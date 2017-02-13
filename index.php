<!DOCTYPE html>
<html lang="fr">

<?php include 'includes/header.php'; ?>
<div id="main_page">
<div class="line-container" id="card_container">

<div class="card">
	<div class="card-header">
		<h2 class="card-title">200000 insoumis, GG à tous!</h2>
		<p class="card-info">il y a 3 heures par Entropy</p>
	</div>
	
	<div class="card-content">
		<img class="card-img" src="https://media.giphy.com/media/3oriNVEGuyvUIMnn1u/source.gif">
		<div class="card-overlay">
			<div class="card-buttons">
				<img id="share_fb" class="card-share"src="assets/Facebook.png"/>
				<img id="share_twitter" class="card-share" src="assets/Twitter.png"/>
				<img id="share_clipboard" class="card-share" src="assets/Clipboard.png"/>
			</div>
		</div>
	</div>

	<div class="card-footer">
		300 <img class="phi-points" src="assets/phi.png"/>
	</div>
</div>


</div>
</div>

<script>

function addCard() {

}


function shareFacebook(e) {
	var card = $(e.target).closest(".card");
	console.log("Share FB"+card);
}
function shareTwitter(e) {
	var card = $(e.target).closest(".card");
	console.log("Share Twitter"+card);
}
function copyClipboard(e) {
	var card = $(e.target).closest(".card");
	var img = card.find(".card-img");
	console.log("Copy clipboard "+img.attr('src'));
}

$(window).on("load", function() {

$("#share_fb").click(shareFacebook);
$("#share_twitter").click(shareTwitter);
$("#share_clipboard").click(copyClipboard);


function hoverIn(e) {
	$(e.target).show();
}
function hoverOut(e) {
	$(e.target).hide();
}

$('.card-content').hover(function() {
		$(this).find(".card-overlay").show();
        $(this).find(".card-overlay").fadeTo(200, 1);

	},
	function() {
		$(this).find(".card-overlay").fadeTo(300, 0, function() {
			$(this).find(".card-overlay").hide();
		});
});
$('.card-share').hover(function() {
        $(this).fadeTo(100, 1);
	},
	function() {
		$(this).fadeTo(200, 0.7);
});


$(".card-img").each(function(i, img) {
	$(img).css({
		position: "relative",
		left: ($(img).parent().width() - $(img).width()) / 2
	});
	$(img).show();
});

});
</script>
<script>
	function getParameterByName(name) {
		
		var url = window.location.href;
		
		name = name.replace(/[\[\]]/g, "\\$&");
		var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
		results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, " "));
	}

	var sort = getParameterByName("sort");
	if(sort == null || sort == "hot") {
		$("#hot").addClass("actif");
	} else if(sort == "new") {
		$("#new").addClass("actif");
	} else if(sort == "random") {
		$("#random").addClass("actif");
	}

</script>
</body>
</html>
