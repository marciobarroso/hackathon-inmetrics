$(document).ready(function(){

	// chain of executions
	checkBrowserRequiriments();	

});

// variables to share informations between APIs
var GOOGLE_API_GEOLOCATION = null;
var GOOGLE_API_RESULTS = null;

// document events functions
function googleApiOnWindowLoad() {
	getUserGeoLocation();
}

function checkBrowserRequiriments() {
	// nothing yet
}

/**
 * Get User Current Geo Location
 * Latitude and Longitude
 */
function getUserGeoLocation() {
	$.getJSON("http://ipinfo.io", function(ipinfo){
    	var latLong = ipinfo.loc.split(",");
    	GOOGLE_API_GEOLOCATION = {"latitude": latLong[0], "longitude": latLong[1]};
    	console.log("Found location ["+ipinfo.loc+"] by ipinfo.io");
    	console.log("Latitude : " + GOOGLE_API_GEOLOCATION.latitude);
    	console.log("Longitude : " + GOOGLE_API_GEOLOCATION.longitude);
	});
}

function googleApiNearbySearch(query) {
	$.ajax({
		type: "GET",
	  	dataType: "json",
	  	url: getNearbySearchUrl(query),
	  	cache: false,
	  	success: function(response){
	  		GOOGLE_API_RESULTS = response;
	  		console.log("success");
			console.log(GOOGLE_API_RESULTS);
	  	}
	});
}

function getNearbySearchUrl(query) {
	var url = "resources/data/google.php?action=nearby&query=" + query;
	url += "&latitude=" + GOOGLE_API_GEOLOCATION.latitude;
	url += "&longitude=" + GOOGLE_API_GEOLOCATION.longitude;
	return url;
}