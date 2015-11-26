<?php

	// all responses must be an XML
	// header('Content-type: application/xml');

	define("GOOGLE_API_KEY", "AIzaSyA0t4XNY5bRhgy1SWPXbWjyCTJsqybFRHs");

	function search() {
		$query = $_GET["query"];
		$latitude = $_GET["latitude"];
		$longitude = $_GET["longitude"];

		$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/xml?";
		$url .= "location=" . $latitude . "," . $longitude;
		$url .= "&radius=5000&query=" . $query;
		$url .= "&key=" . GOOGLE_API_KEY;

		$xml = file_get_contents($url);
		var_dump($xml);
	}

	function error() {
		$result = "<google>\n\t<result>error</result>\n</google>";
		var_dump($result);
	}

	if( isset($_GET["action"]) ) {
		switch( $_GET["action"] ) {
			case "search":
				search();
				break;
			default:
				error();
				break;
		}
	}