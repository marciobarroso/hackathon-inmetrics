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
			fillResultList();
	  	}
	});
}

function fillResultList() {
	var json = GOOGLE_API_RESULTS;
	if( json.google.status === "OK" ) {
		fillResult(json.google.result[0], ".one");
	}
}

function fillResult(result, selector) {
	// reset
	$(selector + " .thumbnail").html("");
	$(selector + " img.photo").prop("alt", "");
	$(selector + " .title").html("");
	$(selector + " .address").html("");
	$(selector + " .phone").html("");
	$(selector + " .website").html("");

	// photo
	var img = $("<img />");
	$(img).prop("class","img-responsive");
	$(img).prop("height","200px");
	$(img).prop("alt",result.name);
	var parent = $(selector + " .thumbnail");
	for( var i=0; i<result.photos.length; i++) {
		$(img).prop("src", result.photos[i].url);
		var div = $("<div></div>");
		$(div).append(img);
		$(parent).append(div);
	}

	// enable slick plugin
	$(selector + ".thumbnail").slick();

	// informations
	$(selector + " .title").append(result.name);
	$(selector + " .address").append(result.formatted_address);
	$(selector + " .phone").append(result.phone_number);
	$(selector + " .website").append(result.website);

	// map
	// createMap(selector + " .map", result.geometry.location.lat, result.geometry.location.lng, result.name);
}

function getNearbySearchUrl(query) {
	var url = "resources/data/google.php?action=nearby&query=" + query;
	url += "&latitude=" + GOOGLE_API_GEOLOCATION.latitude;
	url += "&longitude=" + GOOGLE_API_GEOLOCATION.longitude;
	return url;
}

function createMap(selector, latitude, longitude, label) {
	var coordinates = {lat: latitude, lng: longitude}; 	

	alert("lat -> " + latitude);
	alert("lng -> " + longitude);

	var map = new google.maps.Map($(selector), {
		center: coordinates,
		zoom: 8
	});

	var marker = new google.maps.Marker({
		position: coordinates,
		label: label,
		map: map 
	});
}