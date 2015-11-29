<?php
session_start();
require_once("../twitteroauth/twitteroauth/twitteroauth.php"); //Path to twitteroauth library

include "config.php";
 
define("TWEETS", 10);

function getConnectionWithAccessToken() {
	$consumerkey = "ZSPKZGHZ26QAcyrBAuS1nbWRz";
	$consumersecret = "Fhdhdr9kAAEBIarYiOi1eWGY0YWTBlAGanzxDgOsmrLInn9ZRN";
	$accesstoken = "107810474-cSGLNFYoDvbgzgWp41QGupXUh6PcpkW7qtBiuDF2";
	$accesstokensecret = "Ffxtkx7abYOqd9tJulhExKoyTwUx7pRcd5QbZp0wpwg5i";

	$connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
  	return $connection;
}

function search() {
	$search = getParameter($_GET, "query");
	$connection = getConnectionWithAccessToken();
	$search = str_replace("#", "%23", $search);
	$tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json?q=".$search."&count=". TWEETS);

	$json = json_encode($tweets);

	getLogger()->debug(" -> search tweets -> " . $json);
	print($json);
}

// choose what method call
$action = getParameter($_GET, "action");
if( $action !== null ) {
	switch( $action ) {
		case "search":
			search();
			break;
	}
}
?>