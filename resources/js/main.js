$(document).ready(function(){

	$("#btn-main").click(function(){

		$("div#result").fadeIn();

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
	var startPos;
	var success = function(position) {
    	startPos = position;
    	console.log("Retrieve User Coordinates")
    	console.log("Latitude : " + startPos.coords.latitude);
    	console.log("Longitude : " + startPos.coords.longitude);
  	};
  	
  	var error = function(error) {
  		console.log("Error occurred. Error code : " + error.code);
  		// error.code can be:
	    //   0: unknown error
	    //   1: permission denied
	    //   2: position unavailable (error response from location provider)
	    //   3: timed out
  	};

  	navigator.geolocation.getCurrentPosition(success, error);
}