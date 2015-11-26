var GoogleApiKey = "AIzaSyA0t4XNY5bRhgy1SWPXbWjyCTJsqybFRHs";
var GoogleGeoLocationCurrentPosition = null;

$(document).ready(function(){

	$("#btn-main").click(function(){

		$("div#result").fadeIn();
		var query = $("input#busca").val();
		nearbySearch(query);

	});

	check();

});

// customize the default events
window.onload = function() {
	getUserGeoLocation();
}


function check() {

	if (navigator.geolocation) {
  		console.log('Geolocation is supported!');
	} else {
  		console.log('Geolocation is not supported for this Browser/OS version yet.');
	}

}

/**
 * Get User Current Geo Location
 * Latitude and Longitude
 */
function getUserGeoLocation() {
	var success = function(position) {
    	GoogleGeoLocationCurrentPosition = position;
    	console.log("Retrieve User Coordinates")
    	console.log("Latitude : " + position.coords.latitude);
    	console.log("Longitude : " + position.coords.longitude);
  	};
  	
  	var error = function(error) {
  		console.log("Error occurred. Error code : " + error.code);
  		// error.code can be:
	    //   0: unknown error
	    //   1: permission denied
	    //   2: position unavailable (error response from location provider)
	    //   3: timed out
  	};

  	var options = {
  		maximumAge: 5 * 60 * 1000,
  		timeout: 10 * 1000,
  		enableHighAccuracy: true
  	};

  	navigator.geolocation.getCurrentPosition(success, error, options);
}

function nearbySearch(query) {
	$.getJSON( getNearbySearchUrl(query), function() {
		console.log("call google search api");	
	})

	.done(function(data){
		console.log("success");
		console.log(data);
	})

	.fail(function() {
		console.log("failure");
	});
}

function getNearbySearchUrl(query) {
	var url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?";
	url += "location=" + GoogleGeoLocationCurrentPosition.coords.latitude + "," + GoogleGeoLocationCurrentPosition.coords.longitude;
	url += "&radius=5000&query=" + query;
	url += "&key=" + GoogleApiKey;

	console.log("getNearbySearchUrl("+query+") -> " + url);

	return url;
}