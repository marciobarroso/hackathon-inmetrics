//Initialize Facebook's API
$(document).ready(function(){
		initFacebookAPI();
});

/*
 * The following snippet of code will give the 
 * basic version of the SDK where the options 
 * are set to their most common defaults.
 */
 
 function initFacebookAPI(){
	window.fbAsyncInit = function() {
		FB.init({
			appId : '961829980550657',
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
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
 
}

/*
 * Function that gets page's id based on its name
 */
 /* make the API call */
function getPageId(pageName){
	FB.api(
	  '/' + pageName,
	  'GET',
	  {"fields":"id"},
	  function(response) {
		  // Result
		  if (response && !response.error) {
		  return response.id;
		  }
	  }
	);
		
}
/*
 * Function that gets page's data based on its id
 */
function getPageData(pageName){
	var page-id = this.getPageId(pageName).id;
	/* make the API call */
	FB.api( 
		"/" + page-id,
		'GET',
		{},
		function (response) {
	      if (response && !response.error) {
	        return response;
	      }
	    }
	);


