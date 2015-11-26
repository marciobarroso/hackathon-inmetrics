$(document).ready(function(){

	$("#btn-main").click(function(){

		$("div#result").fadeIn();

	});

	check();

});

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
    	
    	console.log("latitude : " + startPos.coords.latitude);
    	console.log("longitude : " + startPos.coords.longitude);
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

// customize the default events
window.onload = function() {
	getUserGeoLocation();
}
// Get a list of places based on a string
function textSearchPlace(function(getUserGeoLocation)) {
  var place = new google.maps.LatLng(getUserGeoLocation.coords.latitude, getUserGeoLocation.coords.longitude);

  map = new google.maps.Map(document.getElementById('map'), {
      center: place,
      zoom: 15
    });
  var request = {
    location: place,
    radius: '500',
    query: document.getElementById('busca').value;
  };

  service = new google.maps.places.PlacesService(map);
  var placeInformation = service.textSearch(request, callback);
  for(int i = 0; i < placeInformation.length; i++){
	  alert(placeInformation[i].place_id);
  }
}

function callback(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      var place = results[i];
      createMarker(results[i]);
    }
  }
}