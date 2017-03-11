/*
   SDK Facebook
 */
window.fbAsyncInit = function() {
	FB.init({
		appId      : '1849815745277262',
		xfbml      : true,
		version    : 'v2.8',
		cookie     : true
	});
	FB.AppEvents.logPageView();
};

(function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/fr_FR/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function showErreur(msg) {
	var e = `<div class='alert alert-danger erreur'>
	      <a href="#" class="close" data-dismiss="alert" aria-label="fermer">×</a>
		  </div>`;

	var erreur = $(e);
	$('#main_page').prepend(erreur);

	//fade out au bout de 2s
	erreur.delay(2000).animate({'opacity': '0'}, 1000, function() {
		erreur.remove();		
	});

}

function checkFBLogin() {
	FB.login(function(response) {
		if(response.status != "connected")
			return;
		$.post('MODELS/facebookLogin.php', null, function(data) {
			if(data == "success") {
				window.location.href = 'index.php';
			} else if(data.includes("pseudo")){
				window.location.href = 'pseudo.php?erreur=fromregister'+data;
			} else if(data == "banni") {
				showErreur('Erreur ! Vous avez été banni !');
			} else {
				showErreur('Erreur ! Veuillez recommencer.');
			}
		});
	});
}



/*
   Google
 */
function checkGoogleLogin(googleUser) {
	if(googleUser) {
		var idToken = googleUser.getAuthResponse().id_token;

		$.post('MODELS/googleLogin.php', {idtoken: idToken}, function(data) {
			if(data == "success") {
				window.location.href = 'index.php';
			} else if(data.includes("pseudo")){
				window.location.href = 'pseudo.php?erreur=fromregister'+data;
			} else if(data == "banni") {
				showErreur('Erreur ! Vous avez été banni !');
			} else {
				showErreur('Erreur ! Veuillez recommencer.');
			}
		});
	}
}
/*
   Twitter
 */
function checkTwitterLogin() {
	window.open('MODELS/twitterLogin.php?request', '_blank', "height=600,width=600");
}

function onTwitterClose(data) {
	if(data == "success") {
		window.location.href = 'index.php';
	} else if(data.includes("pseudo")){
		window.location.href = 'pseudo.php?erreur=fromregister'+data;
	} else if(data == "banni") {
		showErreur('Erreur ! Vous avez été banni !');
	} else {
		showErreur('Erreur ! Veuillez recommencer.');
	}
}

var google = false;

window.onload = function() {
	var auth2 = gapi.auth2.getAuthInstance();
	auth2.signOut().then(function () {
	});

	$('.g-signin2').click(function() {
		google = true;
	});
}


	$("#facebook_login").click(checkFBLogin);
	$("#twitter_login").click(checkTwitterLogin);
	$("#mail_login").click(function() {
		window.location.href = "login_classic.php";
	});

	gapi.load('auth2', function(){
		// Retrieve the singleton for the GoogleAuth library and set up the client.
		auth2 = gapi.auth2.init({
			client_id: '370224579216-3m4vo3a5isrnthstrg5jga9so291r4an.apps.googleusercontent.com',
			cookiepolicy: 'single_host_origin',
			//scope: 'additional_scope'
		});
		attachSignin(document.getElementById('google_login'));
	});


	function attachSignin(element) {
		auth2.attachClickHandler(element, {},
				function(googleUser) {
					checkGoogleLogin(googleUser);
				}, function(error) {
					console.log(JSON.stringify(error, undefined, 2));
				});
	};

