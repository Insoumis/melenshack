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

function checkFBLogin() {
	$.post('MODELS/facebookLogin.php', null, function(data) {
		if(data == "error") {

		} else if(data == "success") {
			window.location.href = 'index.php';
		} else {
			window.location.href = 'pseudo.php?erreur=fromregister'+data;
		}
	});
}
/*
   Google
 */
function checkGoogleLogin(googleUser) {
	var idToken = googleUser.getAuthResponse().id_token;

	$.post('MODELS/googleLogin.php', {idtoken: idToken}, function(data) {
		if(data == "error") {

		} else if(data == "success") {
			window.location.href = 'index.php';
		} else {
			window.location.href = 'pseudo.php?erreur=fromregister'+data;
		}
	});
}
/*
   Twitter
*/
function checkTwitterLogin() {
	window.open('MODELS/twitterLogin.php?request', '_blank', "height=600,width=600");
}

function onTwitterClose(data) {
	if(data == "error") {

	} else if(data == "redirect") {
		window.location.href = "../pseudo.php";
	} else if(data == "success") {
		window.location.href = '../index.php';
	} else {
		window.location.href = '../pseudo.php?erreur=fromregister'+data;
	}
}
