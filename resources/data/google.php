<?php

	// all responses must be an JSON
	header('Content-Type: application/json');

	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);

	define("GOOGLE_API_KEY", "AIzaSyA0t4XNY5bRhgy1SWPXbWjyCTJsqybFRHs");

	function nearby() {
		$query = $_GET["query"];
		$latitude = $_GET["latitude"];
		$longitude = $_GET["longitude"];

		$url = "https://maps.googleapis.com/maps/api/place/textsearch/json?";
		$url .= "location=" . $latitude . "," . $longitude;
		$url .= "&radius=5000&query=" . $query;
		$url .= "&key=" . GOOGLE_API_KEY;

		$json = file_get_contents($url);
		success($json);
	}

	function success($json) {
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

		$json = json_encode($arr);
		print($json);
	}

	function array_to_xml($template_info, &$xml_template_info) {
		foreach($template_info as $key => $value) {
			if(is_array($value)) {
				if(!is_numeric($key)){
					$subnode = $xml_template_info->addChild("$key");
					array_to_xml($value, $subnode);
				}
				else{
					array_to_xml($value, $xml_template_info);
				}
			}
			else {
				$xml_template_info->addChild("$key","$value");
			}
		}
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
		$json = {"error":true};
		print($json);
	}

	if( isset($_GET["action"]) ) {
		switch( $_GET["action"] ) {
			case "nearby":
				nearby();
				break;
			default:
				error();
				break;
		}
	}