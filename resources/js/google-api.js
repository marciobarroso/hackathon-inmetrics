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
		var selectors = ["one","two","three","four","five","six","seven","eight","nine","then"];
		for( var i=0; i<json.google.result.length; i++ ) {
			resetDivResult(selectors[i]);
			createDivResult(selectors[i]);
			fillResult(json.google.result[i], "." + selectors[i]);
		}
	}

	// enable slick plugin
	$("div.thumbnail").each(function() {
		$(this).slick({
			dots: true,
			infinite: true,
			speed: 500,
			fade: true,
			cssEase: 'linear'
		});
	});
}

function resetDivResult(selector) {
	$(".row ." + selector).remove();
}

function createDivResult(selector) {
	var row = $("<div></div>");
	$(row).prop("class","row " + selector);
	$("div#results").append(row);

	var container = $("<div></div>");
	$(container).prop("class","col-md-12 col-sm-6");
	$(row).append(container);

	var thumbnail = $("<div></div>");
	$(thumbnail).prop("class","col-md-3 thumbnail");
	$(container).append(thumbnail);

	var info = $("<div></div>");
	$(info).prop("class","col-md-5 info");
	$(container).append(info);

	var title = $("<h3></h3>");
	$(title).prop("class","title");
	$(info).append(title);

	var address = $("<p></p>");
	$(address).prop("class","address");
	$(info).append(address);

	var phone = $("<p></p>");
	$(phone).prop("class","phone");
	$(info).append(phone);

	var website = $("<p></p>");
	$(website).prop("class","website");
	$(info).append(website);

	var rating = $("<div></div>");
	$(rating).prop("class","col-md-4 rating");
	$(container).append(rating);
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
	var parent = $(selector + " .thumbnail");
	for( var i=0; i<result.photos.length; i++ ) {
		var img = $("<img />");
		$(img).prop("class","img-responsive");
		$(img).prop("height","200px");
		$(img).prop("alt",result.name);
		$(img).prop("src", result.photos[i].url);
		
		var div = $("<div></div>");
		$(div).append(img);
		$(parent).append(div);
	}

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