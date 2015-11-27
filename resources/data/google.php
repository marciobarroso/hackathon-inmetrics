<?php

	include "config.php";

	// all responses must be an JSON
	header('Content-Type: text/json');
	
	function nearby() {
		$query = $_GET["query"];
		$latitude = $_GET["latitude"];
		$longitude = $_GET["longitude"];

		if( CONFIG_DEBUG ) {
			$url = CONFIG_SERVER_PREFIX . "/resources/data/google-api-nearby.xml";
		} else {
			$url = "https://maps.googleapis.com/maps/api/place/textsearch/xml?";
			$url .= "location=" . $latitude . "," . $longitude;
			$url .= "&radius=5000&query=" . $query;
			$url .= "&key=" . CONFIG_GOOGLE_API_KEY;
		}

		$xml = file_get_contents($url);
		
		$xml = new SimpleXMLElement($xml);
		$json = json_encode($xml);
		$arr = json_decode($json, TRUE);
		$result = array();
		$result["google"] = array();
		$result["google"]["status"] = "OK"; 
		$result["google"]["result"] = array();

		sksort($arr["result"],"rating",false);

		$limit = 5;
		for( $i=0; $i<sizeof($arr["result"]); $i++ ) {
			if( $i < $limit ) {
				$result["google"]["result"][$i] = $arr["result"][$i];
			} else {
				break;
			}
		}

		// load photos
		for( $i=0; $i < sizeof($result["google"]["result"]); $i++ ) {
			if( isset($result["google"]["result"][$i]["photo"]) ) {
				$photo = array();
				$json = getPlaceById($result["google"]["result"][$i]["place_id"]);
				$detail = json_decode($json, TRUE);

				foreach( $detail["result"]["photos"] as $p ) {
					$arr = array();
					$arr["url"] = getPhotoByReference($p["photo_reference"], 300);
					$arr["photo_reference"] = $p["photo_reference"];
					$photo[] = $arr;
				}

				// load other details
				$result["google"]["result"][$i]["phone_number"] = $detail["result"]["formatted_phone_number"];
				$result["google"]["result"][$i]["website"] = $detail["result"]["website"];
				$result["google"]["result"][$i]["photos"] = $photo;
				unset($result["google"]["result"][$i]["photo"]);
			}
		}
		
		//print_r($result);
		$json = json_encode($result);
		print($json);		
	}

	function getPlaceById($placeId) {
		if( CONFIG_DEBUG ) {
			$url = CONFIG_SERVER_PREFIX . "/resources/data/google-api-place-by-id.json";	
		} else {
			$url = "https://maps.googleapis.com/maps/api/place/details/json?placeid=$placeId&key=" . CONFIG_GOOGLE_API_KEY;	
		}
		
		$json = file_get_contents($url);
		return $json;
	}

	function getPhotoByReference($reference, $maxwidth) {
		if( CONFIG_DEBUG ) {
			$url = CONFIG_SERVER_PREFIX . "/resources/data/google-api-photo-by-reference.jpg";
		} else {
			$url  = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=$maxwidth";
			$url .= "&photoreference=$reference&key=" . CONFIG_GOOGLE_API_KEY;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$a = curl_exec($ch); // $a will contain all headers
			$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); // This is what you need, it will return you the last effective URL			
		}

		return $url;
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

	// choose what method call
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