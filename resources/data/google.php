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
		
		$json = json_encode($xml);
		$arr = json_decode($json, TRUE);
		$result = array();
		$result["google"] = array();
		$result["google"]["status"] = "OK"; 
		$result["google"]["result"] = array();

		$arr["result"] = dksort($arr["result"], "rating");

		$limit = 5;
		for( $i=0; $i<sizeof($arr["result"]); $i++ ) {
			if( $i < $limit ) {
				$result["google"]["result"][$i] = $arr["result"][$i];
			} else {
				break;
			}
		}

		print_r($result);
	}

	function dksort($array, $case){
	    if(array_key_exists($case,$array)){
	        $a[$case] = $array[$case];
	        foreach($array as $key=>$val){
	            if($case==$key){

	            }else{
	                $a[$key] = $array[$key];
	            }
	        }
	    }

	    return $a;
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