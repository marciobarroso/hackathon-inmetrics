var GoogleGeoLocationCurrentPosition = null;
var GoogleSearchResult = null;

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
	$.ajax({
		type: "GET",
	  	dataType: "json",
	  	url: getNearbySearchUrl(query),
	  	cache: false,
	  	success: function(response){
	  		GoogleSearchResult = response;
	  		console.log("success");
			console.log(GoogleSearchResult);
	  	}
	});
}

function getNearbySearchUrl(query) {
	var url = "http://ec2-52-91-21-223.compute-1.amazonaws.com/resources/data/google.php?action=nearby&query=" + query;
	url += "latitude=" + GoogleGeoLocationCurrentPosition.coords.latitude + "&longitude=" + GoogleGeoLocationCurrentPosition.coords.longitude;
	return url;
}