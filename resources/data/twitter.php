<?php
session_start();
require_once("../twitteroauth/twitteroauth/twitteroauth.php"); //Path to twitteroauth library
 
$query = getParameter($_GET, "query");
$search = $query;
$notweets = 10;
$consumerkey = "ZSPKZGHZ26QAcyrBAuS1nbWRz";
$consumersecret = "Fhdhdr9kAAEBIarYiOi1eWGY0YWTBlAGanzxDgOsmrLInn9ZRN";
$accesstoken = "107810474-cSGLNFYoDvbgzgWp41QGupXUh6PcpkW7qtBiuDF2";
$accesstokensecret = "Ffxtkx7abYOqd9tJulhExKoyTwUx7pRcd5QbZp0wpwg5i";
 
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}
 
$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
 
$search = str_replace("#", "%23", $search);
$tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json?q=".$search."&count=".$notweets);
 
echo json_encode($tweets);
?>