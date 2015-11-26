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

		sksort($arr["result"],"rating",false);

		$limit = 10;
		for( $i=0; $i<sizeof($arr["result"]); $i++ ) {
			if( $i < $limit ) {
				$result["google"]["result"][$i] = $arr["result"][$i];
			} else {
				break;
			}
		}

		$arr = array_keys($arr);
		$xml = new SimpleXMLElement("<google />");
		array_walk_recursive($arr, array ($xml, 'addChild'));
		echo $xml->asXML();
	}

	function sksort(&$array, $subkey="id", $sort_ascending=false) {

	    if (count($array))
	        $temp_array[key($array)] = array_shift($array);

	    foreach($array as $key => $val){
	        $offset = 0;
	        $found = false;
	        foreach($temp_array as $tmp_key => $tmp_val)
	        {
	            if(!$found and isset($val[$subkey]) and isset($tmp_val[$subkey]) and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey]))
	            {
	                $temp_array = array_merge(    (array)array_slice($temp_array,0,$offset),
	                                            array($key => $val),
	                                            array_slice($temp_array,$offset)
	                                          );
	                $found = true;
	            }
	            $offset++;
	        }
	        if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
	    }

	    if ($sort_ascending) $array = array_reverse($temp_array);

	    else $array = $temp_array;
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