// variables to share informations between APIs
var GOOGLE_API_RESULTS = null;
var GOOGLE_API_GEOLOCATION = null;
var GOOGLE_API_MAP = null;
var GOOGLE_API_MAP_BOUNDS = null;
var GOOGLE_API_LOGGED_PERSON = null;
var GOOGLE_API_MAP_ALL_MARKER = [];

var GOOGLE_API_CLIENT_ID = "510002317093-d22ispdb67db3qsp0umfjfrggbo6s243.apps.googleusercontent.com";
var GOOGLE_API_CLIENT_SECRET = "x5cctYVwfpQifLkHygpkWWfB";
var GOOGLE_API_CLIENT_SCOPE = "https://www.googleapis.com/auth/plus.login";
var GOOGLE_API_ACCESS_TOKEN = null;

var GOOGLE_API_INFO_WINDOW_RANKTOON = "<div class='info-window'><h3>Ranktoon</h3><p>Sua localização atual</p></div>";
var GOOGLE_API_INFO_WINDOW_DEFAULT = "<div class='info-window'><h3>#name#</h3><p>#address#</p></div>";

// document events functions
function googleApiOnWindowLoad() {
	googleApiLoadMap();
	googleApiSetUserGeoLocation();
}

// add a marker on map
function addInfoMarker(lat_, lng_, title_, ranking_) {
	console.log("Add a marker on " + lat_ + ", " + lng_ + ", ranking " + ranking_ + " with title " + title_);

	var iconImage;
	switch(ranking_) {
		case 0:
			iconImage = "resources/images/favicon/favicon-32x32.png";
			break;
		case 1:
			iconImage = "resources/images/icon-one.png";
			break;
		case 2:
			iconImage = "resources/images/icon-two.png";
			break;
		case 3:
			iconImage = "resources/images/icon-three.png";
			break;
		case 4:
			iconImage = "resources/images/icon-four.png";
			break;
		case 5:
			iconImage = "resources/images/icon-five.png";
			break;
		default:
			iconImage = null;
			break;
	}

	console.log("Choose icon : " + iconImage);

	var marker = new google.maps.Marker({
		map: GOOGLE_API_MAP,
		draggable: false,
		animation: google.maps.Animation.DROP,
		position: {lat: lat_, lng: lng_},
		title: title_,
		icon: iconImage,
		loaded: false,
		id: ranking_
	});

	if( ranking_ > 0 ) {
		GOOGLE_API_MAP_ALL_MARKER.push(marker);
	}

	marker.addListener('click', function(){
		infoWindowClick(this.id);
	});

	marker.addListener('mouseover', function(){
		if( !this.loaded ) {
			infoWindowLoad(this.id);
			this.loaded = true;
		}
	});

	// extends map bounds
	GOOGLE_API_MAP_BOUNDS.extend(marker.position);

	//now fit the map to the newly inclusive bounds
	GOOGLE_API_MAP.fitBounds(GOOGLE_API_MAP_BOUNDS);

	console.log("Marker successfull created");
}

// add the user geolocation on map
function addUserGeolocationOnMap() {
	addInfoMarker(
		GOOGLE_API_GEOLOCATION.lat, 
		GOOGLE_API_GEOLOCATION.lng, 
		"RankToon", 
		0
	);
}

function mapReset() {
	for( var i=0; i<GOOGLE_API_MAP_ALL_MARKER.length; i++ ) {
		GOOGLE_API_MAP_ALL_MARKER[i].setMap(null);
	}
	GOOGLE_API_MAP_ALL_MARKER = [];
	GOOGLE_API_MAP_INFO_WINDOW_LIST = [];
}

// load current position of the user
function googleApiSetUserGeoLocation() {
/*	if ( navigator.geolocation ) {

		navigator.geolocation.getCurrentPosition(function(position) {
      		GOOGLE_API_GEOLOCATION = {
        		lat: position.coords.latitude,
        		lng: position.coords.longitude
      		};

      		console.log("User Geolocation found using navigator geolocation");	
			console.log("Latitude : " + Number(GOOGLE_API_GEOLOCATION.lat));
			console.log("Longitude : " + Number(GOOGLE_API_GEOLOCATION.lng));

			GOOGLE_API_MAP.setCenter(GOOGLE_API_GEOLOCATION);
			GOOGLE_API_MAP.setZoom(20);

			addUserGeolocationOnMap();
      	});
    } else {
*/    	$.getJSON("http://ipinfo.io", function(ipinfo){
			var latLong = ipinfo.loc.split(",");
			GOOGLE_API_GEOLOCATION = {
				lat: Number(latLong[0]), 
				lng: Number(latLong[1])
			};

			console.log("User Geolocation found using iponfo.loc");	
			console.log("Latitude : " + Number(GOOGLE_API_GEOLOCATION.lat));
			console.log("Longitude : " + Number(GOOGLE_API_GEOLOCATION.lng));

			GOOGLE_API_MAP.setCenter(GOOGLE_API_GEOLOCATION);
			GOOGLE_API_MAP.setZoom(20);

			addUserGeolocationOnMap();
//		});
	}
}

/**
 * Load map
 */
function googleApiLoadMap() {
	// load map
	GOOGLE_API_MAP = new google.maps.Map(document.getElementById('map'), {
    	center: {lat: -34.397, lng: 150.644},
    	zoom: 6
  	});

  	GOOGLE_API_MAP_BOUNDS = new google.maps.LatLngBounds();
}

function googleApiNearbySearch(query) {
	mapReset();

	console.log("Call nearby search method");
	$.ajax({
		type: "GET",
	  	dataType: "json",
	  	url: getNearbySearchUrl(query),
	  	cache: false,
	  	success: function(response){
	  		console.log("Nearby search method successfull called : " + response);
	  		GOOGLE_API_RESULTS = response;
	  		console.log("success");
			console.log(GOOGLE_API_RESULTS);

			if( GOOGLE_API_RESULTS.google.result !== undefined && GOOGLE_API_RESULTS.google.result.length > 0 ) {
				setResultsOnMap();
			} else {
				alert("Cota free da Google API esgotada");
			}
	  	}
	});
}

function setResultsOnMap() {
	console.log("set the results on the map");

	var json = GOOGLE_API_RESULTS;
	if( json.google.status === "OK" ) {
		for( var i=0; i<json.google.result.length; i++ ) {
			var result = json.google.result[i]; 
			addInfoMarker(
				Number(result.geometry.location.lat), 
				Number(result.geometry.location.lng), 
				result.name, 
				Number(i+1)
			);
		}
	}
}

function getNearbySearchUrl(query) {
	var url = "resources/data/google.php?action=nearby&query=" + query;
	url += "&latitude=" + GOOGLE_API_GEOLOCATION.lat;
	url += "&longitude=" + GOOGLE_API_GEOLOCATION.lng;
	return url;
}

function infoWindowClick(id) {
	if( id === 0 ) {
		infoWindowRanktoon();
	} else {
		$("div#modal").modal();
	}

	console.log("open infowindow " + id);
} 

function infoWindowLoad(id) {
	console.log("loading informations for marker " + id);



}

function infoWindowRanktoon() {
	$("div#modal").modal();


}