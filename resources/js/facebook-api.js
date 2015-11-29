//Facebook App Informations
var FACEBOOK_API_ACCESS_KEY = '961829980550657|520f6f1666c7ee84b52aa00eab17d073';
var FACEBOOK_API_ID = '961829980550657';
var FACEBOOK_API_FIELDS = "likes,checkins,website,phone";
var FACEBOOK_API_RESULTS;

function facebookApiOnWindowLoad() {
    initFacebookAPI();
}

/*
 * The following snippet of code will give the 
 * basic version of the SDK where the options 
 * are set to their most common defaults.
 */
function initFacebookAPI(){
	window.fbAsyncInit = function() {
		FB.init({
			appId : FACEBOOK_API_ACCESS_KEY,
            xfbml : true,
			version : 'v2.5'
		});
	};
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {
			return;
		}
		js = d.createElement(s);
		js.id = id;
		js.src = "https://connect.facebook.net/pt_BR/all.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
}

/*
 * Function that gets page's informations based on the result from google api
 */
 /* make the API call */

function facebookApiLoadInformationByUser(name, result) {
    FB.api(
        '/' + name, 
        'GET',
        {"access_token": FACEBOOK_API_ACCESS_KEY, "fields": FACEBOOK_API_FIELDS },
        function(response) {
            FACEBOOK_API_RESULTS = response;
            result.facebook = response;
            if (FACEBOOK_API_RESULTS === undefined) {
                alert("Ocorreu um erro com o resultado da busca da página");
            }
        }
    );
}
