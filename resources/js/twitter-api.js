// JQuery Twitter Feed. Coded by Tom Elliott (Web Dev Door) www.webdevdoor.com (2013)
//UPDATED TO AUTHENTICATE TO API 1.1

var TWITTER_API_RESULT = null;

function twitterApiGetTweetsByUser(name, result) {
	console.log("Call Twitter Search");
	
	$.ajax({
		type: "GET",
	  	dataType: "json",
	  	url: "resources/data/twitter.php?action=search&query=" + name,
	  	cache: false,
	  	success: function(response){
	  		console.log("Twitter Search successfull called : " + response);
	  		if( response !== undefined && response !== null && response.statuses ) {
		  		result.twitter = [];
		  		TWITTER_API_RESULTS = response.response;
		  		console.log("success");
		  		result.twitter.feeds = response.statuses;
		  		console.log("Twitter Search Result Found");
		  	} else {
		  		console.log("Twitter Search Error");
		  	}
	  	}
	});

}