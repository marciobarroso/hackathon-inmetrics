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

		$status = $xml->children("status","OK");
		if( count($status) === 1 ) {
			$count = 0;
			foreach( $results as $result ) {
				if( $count++ >= 5 ) {
					//$dom = dom_import_simplexml($result);
					//$dom->parentNode->removeChild($dom);
					unset($result);
				}
			}

			echo $xml->asXML();	
		} else {
			echo "Error";
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