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
	if ( navigator.geolocation ) {

		navigator.geolocation.getCurrentPosition(function(position) {
      		GOOGLE_API_GEOLOCATION = {
        		lat: position.coords.latitude,
        		lng: position.coords.longitude
      		};

      		console.log("User Geolocation found using navigator geolocation");	
			console.log("Latitude : " + Number(GOOGLE_API_GEOLOCATION.lat));
			console.log("Longitude : " + Number(GOOGLE_API_GEOLOCATION.lng));

			GOOGLE_API_MAP.setCenter(GOOGLE_API_GEOLOCATION);
			GOOGLE_API_MAP.setZoom(15);

			addUserGeolocationOnMap();
      	});
    } else {
    	$.getJSON("http://ipinfo.io", function(ipinfo){
			var latLong = ipinfo.loc.split(",");
			GOOGLE_API_GEOLOCATION = {
				lat: Number(latLong[0]), 
				lng: Number(latLong[1])
			};

			console.log("User Geolocation found using iponfo.loc");	
			console.log("Latitude : " + Number(GOOGLE_API_GEOLOCATION.lat));
			console.log("Longitude : " + Number(GOOGLE_API_GEOLOCATION.lng));

			GOOGLE_API_MAP.setCenter(GOOGLE_API_GEOLOCATION);
			GOOGLE_API_MAP.setZoom(15);

			addUserGeolocationOnMap();
		});
	}
}

/**
 * Load map
 */
function googleApiLoadMap() {
	// load map
	GOOGLE_API_MAP = new google.maps.Map(document.getElementById('map'), {
    	center: {lat: -34.397, lng: 150.644},
    	zoom: 15
  	});

  	GOOGLE_API_MAP_BOUNDS = new google.maps.LatLngBounds();
  	GOOGLE_API_MAP.setZoom(15);
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
			} else if( GOOGLE_API_RESULTS.google.status == "ERROR" ) {
				alert("Nenhum resultado encontrado para a busca");
			}
	  	}
	});
}

function googleApiCallFacebookAndTwitterApis() {
	
	for( var i=0; i<GOOGLE_API_RESULTS.google.result.length; i++ ) {
		var result = GOOGLE_API_RESULTS.google.result[i];
		googleApiSearchFacebookUser(result);	
	}

	for( var i=0; i<GOOGLE_API_RESULTS.google.result.length; i++ ) {
		var result = GOOGLE_API_RESULTS.google.result[i];
		twitterApiGetTweetsByUser(result.name, result);
	}

}

function googleApiSearchFacebookUser(result) {
	
	$.ajax({
		type: "GET",
	  	dataType: "json",
	  	url: "resources/data/google.php?action=facebook&query=" + result.name,
	  	cache: false,
	  	success: function(response){
	  		console.log("Facebook search call response : " + response.facebook.status);
	  		if( response.facebook.status == "OK" ) {
	  			var facebook = response.facebook.result;
	  			console.log("Search Facebook User for " + facebook);
	  			result.facebook_user = facebook;
	  			facebookApiLoadInformationByUser(facebook, result);
	  			console.log("Facebook data successful loaded for " + result.name);
			} else {
				alert(response.facebook.status);
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

	googleApiCallFacebookAndTwitterApis();
}

function getNearbySearchUrl(query) {
	var url = "resources/data/google.php?action=nearby&query=" + query;
	url += "&latitude=" + GOOGLE_API_GEOLOCATION.lat;
	url += "&longitude=" + GOOGLE_API_GEOLOCATION.lng;
	return url;
}

function infoWindowClick(id) {
	console.log("open infowindow " + id);
	infoWindowLoad(id);
	$("div#modal").modal();
} 

function infoWindowLoad(id) {
	console.log("loading informations for marker " + id);
	var call;
	if( id == 0 ) {
		call = "resources/data/ranktoon.php?action=info";
		$.ajax({
			type: "GET",
			url: call,
			dataType: "json",
			success: function(data) {
				fillModal(id,data);
			}
		});
	} else {
		fillModal(id, GOOGLE_API_RESULTS.google.result[id-1]);
	}
}

function fillModal(type,data) {
	if( type == 0 ) {
		$(".title").html(data.ranktoon.name);

		var body = $("div.modal-body");
		$(body).html("");

		var rowOne = $("<div class='row'></div>");
		$(body).append(rowOne);

		var rowOneCol = $("<div class='col-md-12'></div>");
		$(rowOne).append(rowOneCol);
		
		var image = $("<img class='img-responsive' border='0' />")	
			.prop("src", data.ranktoon.image);
		$(rowOneCol).append(image);	

		var rowTwo = $("<div class='row'></div>");
		$(rowTwo).css("padding-top","20px");
		$(body).append(rowTwo);

		var rowTwoCol = $("<div class='col-md-12'></div>");
		$(rowTwo).append(rowTwoCol);

		// tabs
		var ul = $("<ul class='nav nav-tabs'></ul>");
		$(rowTwoCol).append(ul);

		var item_who_we_are = $("<li class='active'></li>");
		$(ul).append(item_who_we_are);

		var link_who_we_are = $("<a data-toggle='tab' href='#who_we_are'></a>");
		$(link_who_we_are).html("Quem somos");
		$(item_who_we_are).append(link_who_we_are);

		var item_institutional = $("<li></li>")
		$(ul).append(item_institutional);

		var link_institutional = $("<a data-toggle='tab' href='#institutional'></a>");
		$(link_institutional).html("Institucional");
		$(item_institutional).append(link_institutional);

		var item_facebook = $("<li></li>")
		$(ul).append(item_facebook);

		var link_facebook = $("<a data-toggle='tab' href='#facebook'></a>");
		$(link_facebook).html("Facebook");
		$(item_facebook).append(link_facebook);

		var item_twitter = $("<li></li>")
		$(ul).append(item_twitter);

		var link_twitter = $("<a data-toggle='tab' href='#twitter'></a>");
		$(link_twitter).html("Twitter");
		$(item_twitter).append(link_twitter);

		var item_contact = $("<li></li>")
		$(ul).append(item_contact);

		var link_contact = $("<a data-toggle='tab' href='#contact'></a>");
		$(link_contact).html("Contatos");
		$(item_contact).append(link_contact);

		var tab_content = $("<div class='tab-content'></div>");
		$(rowTwoCol).append(tab_content);

		var tab_who_we_are = $("<div id='who_we_are' class='tab-pane fade in active row'></div>");
		$(tab_content).append(tab_who_we_are);

		var tab_who_we_are_col = $("<div class='col-md-12'></div>");
		$(tab_who_we_are).append(tab_who_we_are_col);

		var tab_who_we_are_col_h3 = $("<h3 class='info'></h3>");
		$(tab_who_we_are_col).append(tab_who_we_are_col_h3);
		$(tab_who_we_are_col_h3).html("Quem somos ... ");

		var tab_who_we_are_col_p = $("<p class='description'></p>");
		$(tab_who_we_are_col).append(tab_who_we_are_col_p);
		$(tab_who_we_are_col_p).html(data.ranktoon.description);

		var tab_institutional = $("<div id='institutional' class='tab-pane fade row'></div>");
		$(tab_content).append(tab_institutional);

		var tab_institutional_col = $("<div class='col-md-12'></div>");
		$(tab_institutional).append(tab_institutional_col);

		var tab_institutional_col_h3 = $("<h3 class='info'></h3>");
		$(tab_institutional_col).append(tab_institutional_col_h3);
		$(tab_institutional_col_h3).html("Institucional");

		var tab_institutional_col_p = $("<p class='institutional'></p>");
		$(tab_institutional_col).append(tab_institutional_col_p);
		$(tab_institutional_col_p).html(data.ranktoon.institutional);

		var tab_facebook = $("<div id='facebook' class='tab-pane fade row'></div>");
		$(tab_content).append(tab_facebook);

		var tab_facebook_col = $("<div class='col-md-12'></div>");
		$(tab_facebook).append(tab_facebook_col);

		var tab_facebook_col_h3 = $("<h3 class='info'></h3>");
		$(tab_facebook_col).append(tab_facebook_col_h3);
		$(tab_facebook_col_h3).html("Nossos números no <b>Facebook</b>");

		var tab_facebook_col_p_likes = $("<p class='likes'></p>");
		$(tab_facebook_col).append(tab_facebook_col_p_likes);
		$(tab_facebook_col_p_likes).html("Likes: <b> 0 </b>");

		var tab_facebook_col_p_checkins = $("<p class='checkins'></p>");
		$(tab_facebook_col).append(tab_facebook_col_p_checkins);
		$(tab_facebook_col_p_checkins).html("Checkins: <b> 0 </b>");

		var tab_twitter = $("<div id='twitter' class='tab-pane fade row'></div>");
		$(tab_content).append(tab_twitter);

		var tab_twitter_row = $("<div class='col-md-12'></div>");
		$(tab_twitter).append(tab_twitter_row);
		$(tab_twitter_row).html("<h3>Nossas men&ccedil;&otilde;es no <b>Twitter</b></h3>");

		if( data.ranktoon.twitter.twetts.length == 0 ) {

			var xxxxxx = $("<div class='col-md-12'></div>");
			$(tab_twitter_row).append(xxxxxx);
			$(xxxxxx).html("<h4>Sem men&ccedil;&otilde;es</h4>");

		} else {


			for( var i=0; i<data.ranktoon.twitter.twetts.length; i++ ) {

				var tab_twitter_col_left = $("<div class='col-md-1'></div>");
				$(tab_twitter_row).append(tab_twitter_col_left);

				var tab_twitter_col_left_image = $("<img class='img-responsive' width='60' heigth='60' border='0' />")
					.prop("src", "resources/images/twitter_profile.png");
				$(tab_twitter_col_left).append(tab_twitter_col_left_image);

				var tab_twitter_col_right = $("<div class='col-md-11'></div>");
				$(tab_twitter_row).append(tab_twitter_col_right);

				var tab_twitter_col_right_link = $("<a></a>")
					.prop("href","http://twitter.com/" + "usuario"); // set the username
				$(tab_twitter_col_right).append(tab_twitter_col_right_link);

				var tab_twitter_col_right_span_name = $("<span class='name'></span>")
					.html("Name");
				$(tab_twitter_col_right_link).append(tab_twitter_col_right_span_name);

				var tab_twitter_col_right_span_user = $("<span class='user'></span>")
					.html(" - @usuario");
				$(tab_twitter_col_right_link).append(tab_twitter_col_right_span_user);
				
				var tab_twitter_col_right_message = $("<p class='message'></p>")
					.html("bla bla bla bla");
				$(tab_twitter_row).append(tab_twitter_col_right_message);

				$(tab_twitter_row).append($("<hr />"));
			}

		}

		var tab_contact = $("<div id='contact' class='tab-pane fade row'></div>");
		$(tab_content).append(tab_contact);

		var tab_contact_col = $("<div class='col-md-12'></div>");
		$(tab_contact).append(tab_contact_col);

		var tab_contact_col_h3 = $("<h3 class='info'></h3>");
		$(tab_contact_col).append(tab_contact_col_h3);
		$(tab_contact_col_h3).html("Entre em contato conosco ... ");

		var tab_contact_name = $("<p class='name'></p>");
		$(tab_contact_col).append(tab_contact_name);
		$(tab_contact_name).html(data.ranktoon.name);

		var tab_contact_address = $("<p class='address'></p>");
		$(tab_contact_col).append(tab_contact_address);
		$(tab_contact_address).html(data.ranktoon.address);

		var tab_contact_address = $("<p class='address'></p>");
		$(tab_contact_col).append(tab_contact_address);
		$(tab_contact_address).html(data.ranktoon.address);

		var tab_contact_phone = $("<p class='phone'></p>");
		$(tab_contact_col).append(tab_contact_phone);
		
		var phones = "";
		var separator = "";
		for( var i=0; i<data.ranktoon.phone.length; i++ ) {
			phones += separator + data.ranktoon.phone[i];
			separator = " / ";	
		}
		$(tab_contact_address).html(phones);

		var tab_contact_mail = $("<p class='mail'></p>");
		$(tab_contact_col).append(tab_contact_mail);
		$(tab_contact_mail).html(data.ranktoon.mail);

		$(".nav-tabs a[href='#who_we_are']").tab("show");
	} else {

		var result = data;

		console.log(" draw components -> " + result.name);

		$(".title").html(result.name);

		var body = $("div.modal-body");
		$(body).html("");

		var rowOne = $("<div class='row'></div>");
		$(body).append(rowOne);

		var rowOneCol = $("<div class='col-md-4 thumbnail'></div>");
		$(rowOne).append(rowOneCol);
		
		if( result.photo !== undefined ) {
			var image = $("<img class='img-responsive' border='0' />")	
				.prop("src", result.photo);
			$(rowOneCol).append(image);	
		} else {
			var image = $("<img class='img-responsive' border='0' />")	
				.prop("src", "resources/images/no-image.jpg");
			$(rowOneCol).append(image);
		}
		
		var rowTwoCol = $("<div class='col-md-8 info'></div>");
		$(rowOne).append(rowTwoCol);

		var p_address = $("<p class='address'></p>")
			.html(result.vicinity);
		$(rowTwoCol).append(p_address);

		if( result.facebook != undefined && result.facebook.phone ) {		

			var p_phone = $("<p class='phone'></p>")
				.html(result.facebook.phone);
			$(rowTwoCol).append(p_phone);

		}

		if( result.facebook != undefined && result.facebook.website ) {

			var p_website = $("<p class='website'></p>")
				.html(result.facebook.website);
			$(rowTwoCol).append(p_website);

		}

		var rowTwo = $("<div class='row'></div>");
		$(body).append(rowTwo);

		var rowTwoCol = $("<div class='col-md-12 text-left'></div>");
		$(rowTwoCol).html("<h3>O que est&atilde;o falando sobre <b class='title'>" + result.name + "</b> nas redes sociais</h3>");
		$(rowTwo).append(rowTwoCol);

		var rowThree = $("<div class='row'></div>");
		$(body).append(rowThree);

		var rowThreeCol = $("<div class='col-md-12'></div>");
		$(rowThree).append(rowThreeCol);

		// tabs
		var ul = $("<ul class='nav nav-tabs'></ul>");
		$(rowTwoCol).append(ul);

		var item_facebook = $("<li></li>")
		$(ul).append(item_facebook);

		var link_facebook = $("<a data-toggle='tab' href='#facebook'></a>");
		$(link_facebook).html("Facebook");
		$(item_facebook).append(link_facebook);

		var item_twitter = $("<li></li>")
		$(ul).append(item_twitter);

		var link_twitter = $("<a data-toggle='tab' href='#twitter'></a>");
		$(link_twitter).html("Twitter");
		$(item_twitter).append(link_twitter);

		var item_graphics = $("<li></li>")
		$(ul).append(item_graphics);

		var link_graphics = $("<a data-toggle='tab' href='#graphics'></a>");
		$(link_graphics).html("An&aacute;lise Visual");
		$(item_graphics).append(link_graphics);

		var tab_content = $("<div class='tab-content'></div>");
		$(rowTwoCol).append(tab_content);

		var tab_facebook = $("<div id='facebook' class='tab-pane fade row'></div>");
		$(tab_content).append(tab_facebook);

		var tab_facebook_col = $("<div class='col-md-12'></div>");
		$(tab_facebook).append(tab_facebook_col);

		var tab_facebook_col_h3 = $("<h3 class='info'></h3>");
		$(tab_facebook_col).append(tab_facebook_col_h3);
		$(tab_facebook_col_h3).html("Nossos números no <b>Facebook</b>");

		var tab_facebook_col_p_likes = $("<p class='likes'></p>");
		$(tab_facebook_col).append(tab_facebook_col_p_likes);

		if( result.facebook && result.facebook.likes ) {
			$(tab_facebook_col_p_likes).html("Likes: <b>" + result.facebook.likes + "</b>");	
		} else {
			$(tab_facebook_col_p_likes).html("Likes: <b>0</b>");	
		}

		var tab_facebook_col_p_checkins = $("<p class='checkins'></p>");
		$(tab_facebook_col).append(tab_facebook_col_p_checkins);

		if( result.facebook && result.facebook.checkins ) {
			$(tab_facebook_col_p_checkins).html("Checkins: <b>" + result.facebook.checkins + "</b>");
		} else {
			$(tab_facebook_col_p_checkins).html("Checkins: <b>0</b>");
		}

		var tab_twitter = $("<div id='twitter' class='tab-pane fade row'></div>");
		$(tab_content).append(tab_twitter);

		var tab_twitter_row = $("<div class='col-md-12'></div>");
		$(tab_twitter).append(tab_twitter_row);
		$(tab_twitter_row).html("<h3>Nossas men&ccedil;&otilde;es no <b>Twitter</b></h3>");

		if( result.twitter !== undefined && result.twitter.feeds !== undefined ) {


			for( var i=0; i<result.twitter.feeds.length; i++ ) {
				var feed = result.twitter.feeds[i];

				var tab_twitter_col_left = $("<div class='col-md-1'></div>");
				$(tab_twitter_row).append(tab_twitter_col_left);

				var tab_twitter_col_left_image = $("<img class='img-responsive' width='60' heigth='60' border='0' />")
					.prop("src", feed.user.profile_image_url_https);
				$(tab_twitter_col_left).append(tab_twitter_col_left_image);

				var tab_twitter_col_right = $("<div class='col-md-11'></div>");
				$(tab_twitter_row).append(tab_twitter_col_right);

				var tab_twitter_col_right_link = $("<a></a>")
					.prop("href","http://twitter.com/" + feed.user.name); // set the username
				$(tab_twitter_col_right).append(tab_twitter_col_right_link);

				var tab_twitter_col_right_span_name = $("<span class='name'></span>")
					.html(feed.user.screen_name);
				$(tab_twitter_col_right_link).append(tab_twitter_col_right_span_name);

				var tab_twitter_col_right_span_user = $("<span class='user'></span>")
					.html(" - @" + feed.user.name);
				$(tab_twitter_col_right_link).append(tab_twitter_col_right_span_user);
				
				var tab_twitter_col_right_message = $("<p class='message'></p>")
					.html(feed.text);
				$(tab_twitter_row).append(tab_twitter_col_right_message);

				$(tab_twitter_row).append($("<hr />"));
			}


		}

		var tab_graphics = $("<div id='graphics' class='tab-pane fade row'></div>");
		$(tab_content).append(tab_graphics);

		var tab_graphics_col = $("<div class='col-md-12'></div>");
		$(tab_graphics).append(tab_graphics_col);

		$(".nav-tabs a[href='#facebook']").tab("show");

	}


}