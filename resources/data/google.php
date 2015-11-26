<?php

	// all responses must be an XML
	// header('Content-type: application/xml');

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	define("GOOGLE_API_KEY", "AIzaSyA0t4XNY5bRhgy1SWPXbWjyCTJsqybFRHs");

	function search() {
		$query = $_GET["query"];
		$latitude = $_GET["latitude"];
		$longitude = $_GET["longitude"];

		$url = "https://maps.googleapis.com/maps/api/place/textsearch/xml?";
		$url .= "location=" . $latitude . "," . $longitude;
		$url .= "&radius=5000&query=" . $query;
		$url .= "&key=" . GOOGLE_API_KEY;

		$xml = file_get_contents($url);
		success($xml);
	}

	function success($xml) {
		$xml = new SimpleXMLElement($xml);

		print_r($xml->result);

		print_r($xml->status);

		$count = 0;
		if( count($xml->status) === 1 ) {
			while( count($xml->result) > 5 ) {
				$dom = dom_import_simplexml($xml->result[$count]);
				$dom->parentNode->removeChild($dom);
			}
			$count++;	
			//echo $xml->asXML();	
		}
	}

	function error() {
		$result = "<google>\n\t<result>error</result>\n</google>";
		$xml = new SimpleXMLElement($result);
		echo $xml->asXML();	
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