<!DOCTYPE html>
<html lang="fr">

<?php include 'includes/header.php'; ?>
<div id="main_page">
<div class="line-container" id="card_container">



</div>
</div>

<script>

function addCard(title, imgSource, tags) {
	var card = $("<div class='card'><h3 style='margin-bottom: 0' class='card-title'>"+title+"</h3><p style='margin-bottom: -15px'><small>il y a 3 heures</small></p><center><img class='card-img' width='300px' src='"+imgSource+"'></center><p>"+tags+"</p></div>");

$("#card_container").append(card);

}
for(i = 0; i < 20; ++i) {
	addCard("Titre", "https://upload.wikimedia.org/wikipedia/commons/thumb/0/08/Jean-Luc_M%C3%A9lenchon_-_avril_2012.jpg/220px-Jean-Luc_M%C3%A9lenchon_-_avril_2012.jpg", "tag1 tag2");
}

</script>
</body>
</html>
