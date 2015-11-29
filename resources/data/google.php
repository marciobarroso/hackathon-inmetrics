<?php

	include "config.php";

	define("GOOGLE_API_DEBUG", FALSE);
	define("GOOGLE_API_RESULT_SESSION", "GOOGLE_API_RESULT_SESSION");


	// all responses must be an JSON
	header('Content-Type: text/json');
	
	function debug($msg) {
		if( GOOGLE_API_DEBUG === TRUE ) {
			echo $msg . "\r\n";	
		}
	}

	function nearby() {
		$LIMIT_RESULT = 5;
		$START_RADIUS = 0;

		if( GOOGLE_API_DEBUG === TRUE ) {
			$start = new DateTime();
			debug(" -> nearby start at " . $start->format('Y-m-d H:i:s'));
		}

		$query = getParameter($_GET, "query");
		$latitude = getParameter($_GET, "latitude");
		$longitude = getParameter($_GET, "longitude");

		getLogger()->debug(" -> enter nearby method with parameters '$query', '$latitude' and '$longitude'");

		$json = null;
		$arr = null;
		$decision = FALSE;

		while( $arr === null || (isset($arr["result"]) && sizeof($arr["result"]) < 5) ) {

			// add 1000 to the distance
			$START_RADIUS = $START_RADIUS + 1000;

			if( CONFIG_DEBUG === TRUE ) {
				$url = CONFIG_SERVER_PREFIX . "/resources/data/google-api-nearby.xml";
			} else {
				$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/xml?";
				// required parameters
				$url .= "&key=" . CONFIG_GOOGLE_API_KEY;
				$url .= "&location=" . $latitude . "," . $longitude;

				// optionals parameters
				$url .= "&radius=" . $START_RADIUS;
				$url .= "&keyword=" . $query;
				$url .= "&rankby=prominence";
				
			}

			getLogger()->debug(" -> call url $url");

			if( GOOGLE_API_DEBUG === TRUE ) {
				$call = new DateTime();
			}

			$xml = file_get_contents($url);

			if( GOOGLE_API_DEBUG === TRUE ) {
				$elapsed = $start->diff($call);
				debug(" -> call google api at " . $call->format('Y-m-d H:i:s'));
				debug(" -> elapsed time : " . $elapsed->format("%H:%I:%S") . " millisencods");
			}
			
			$xml = new SimpleXMLElement($xml);
			$json = json_encode($xml);
			$arr = json_decode($json, TRUE);
			$arr["GOOGLE_API_KEY"] = CONFIG_GOOGLE_API_KEY;

			if( $arr["status"] === "ZERO_RESULTS" ) {
				getLogger()->debug(" -> zero results");
				$result = array();
				$result["google"] = array();
				$result["google"]["status"] = "ERROR";
				$result["google"]["message"] = "No results found";
				$json = json_encode($result);
				print($json);
				return;
			}
		}
			
		$result = array();
		$result["google"] = array();
		$result["google"]["status"] = "OK"; 
		$result["google"]["result"] = array();

		if( GOOGLE_API_DEBUG === TRUE ) {
			$call = new DateTime();
		}

		sksort($arr["result"],"rating",false);

		if( GOOGLE_API_DEBUG === TRUE ) {
			$elapsed = $start->diff($call);
			debug(" -> call sort algorithm at " . $call->format('Y-m-d H:i:s'));
			debug(" -> elapsed time : " . $elapsed->format("%H:%I:%S") . " millisencods");
		}

		if( GOOGLE_API_DEBUG === TRUE ) {
			$call = new DateTime();
		}

		$LIMIT_RESULT = 5;
		for( $i=0; $i<sizeof($arr["result"]); $i++ ) {
			if( $i < $LIMIT_RESULT ) {
				if( isset($arr["result"][$i]) ) {
					$result["google"]["result"][$i] = $arr["result"][$i];
				
					if( isset($result["google"]["result"][$i]["photo"]) ) {
						$result["google"]["result"][$i]["photo"] = getPhotoByReference($result["google"]["result"][$i]["photo"]["photo_reference"], 300, 200);
					}
				}
			} else {
				break;
			}
		}

		if( GOOGLE_API_DEBUG === TRUE ) {
			$elapsed = $start->diff($call);
			debug(" -> call photo load at " . $call->format('Y-m-d H:i:s'));
			debug(" -> elapsed time : " . $elapsed->format("%H:%I:%S") . " millisencods");
		}

		// load photos
/*		for( $i=0; $i < sizeof($result["google"]["result"]); $i++ ) {
			if( isset($result["google"]["result"][$i]["photo"]) ) {
				$photo = array();
				$json = getPlaceById($result["google"]["result"][$i]["place_id"]);
				$detail = json_decode($json, TRUE);

				foreach( $detail["result"]["photos"] as $p ) {
					$arr = array();
					$arr["url"] = getPhotoByReference($p["photo_reference"], 300, 200);
					$arr["photo_reference"] = $p["photo_reference"];
					$photo[] = $arr;
				}

				// load other details
				if( isset($detail["result"]["formatted_phone_number"]) ) {
					$result["google"]["result"][$i]["phone_number"] = $detail["result"]["formatted_phone_number"];	
				} else {
					$result["google"]["result"][$i]["phone_number"] = "";
				}

				if( isset($detail["result"]["website"]) ) {
					$result["google"]["result"][$i]["website"] = $detail["result"]["website"];	
				} else {
					$result["google"]["result"][$i]["website"] = "";
				}
				
				$result["google"]["result"][$i]["photos"] = $photo;
				unset($result["google"]["result"][$i]["photo"]);
			}
		}
*/		
		//print_r($result);
		$json = json_encode($result);

		$_SESSION[GOOGLE_API_RESULT_SESSION] = $json;

		getLogger()->debug(" -> return $json");
		print($json);		
	}

	function getPlaceById($placeId) {
		if( CONFIG_DEBUG === TRUE ) {
			$url = CONFIG_SERVER_PREFIX . "/resources/data/google-api-place-by-id.json";	
		} else {
			$url = "https://maps.googleapis.com/maps/api/place/details/json?placeid=$placeId&key=" . CONFIG_GOOGLE_API_KEY;	
		}
		
		$json = file_get_contents($url);
		return $json;
	}

	function getPhotoByReference($reference, $maxwidth, $maxheight) {
		if( CONFIG_DEBUG === TRUE ) {
			$url = CONFIG_SERVER_PREFIX . "/resources/data/google-api-photo-by-reference.jpg";
		} else {
			$url  = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=$maxwidth&maxheight=$maxheight";
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
		$temp_array = array();

	    if ( count($array) > 0 ) {
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
	}

	function search() {
		$query = getParameter($_GET, "query");
		$url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=$query";
		$json = file_get_contents($url);
		print($json);
	}

	function facebook() {
		$query = getParameter($_GET, "query");
		
		if( strpos($query, "-") > -1 ) {
			$query = substr($query, 0, strpos($query, "-") -1);
		}

		$query .= "+facebook";
		$url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=$query";
		
		$json = null;
		$arr = null;
		$check = 1;
		while( $arr === null || ( isset($arr["responseStatus"]) && $arr["responseStatus"] === 403 ) && $check < 5) {

			getLogger()->debug(" -> facebook call for " . $check++ . " time(s)");

			$json = file_get_contents($url);
			$arr = json_decode($json, TRUE);
			//print_r($arr);

			$likes = array();
			$count = 0;
			if( isset($arr["responseData"]) && isset($arr["responseData"]["results"]) && sizeof($arr["responseData"]["results"]) > 1 ) {
				foreach( $arr["responseData"]["results"] as $res ) {
					$content = $res["content"];
					if( strpos($content, "curtidas" ) > -1 ) {
						$curtidas = substr( $content, 0, strpos($content, " curtidas" ));
						$curtidas = substr($curtidas, strrpos($curtidas," ")+1, strlen($curtidas));
						getLogger()->debug(" -> facebook curtidas " . $curtidas);

						if( is_numeric($curtidas) ) {
							$likes[$count] = $curtidas;
						}
					}
					$count++;
				}
				arsort($likes);

				// if has likes, pick the first
				if( sizeof($likes) > 0 ) {
					$value = array_values($likes)[0];
					$key = array_search($value, $likes);

					$regex = '/(?:https?:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)/';
					preg_match($regex, $arr["responseData"]["results"][$key]["unescapedUrl"],$matches, PREG_OFFSET_CAPTURE, 3);
					if( isset($matches) && sizeof($matches) == 2 && !is_numeric($matches[1][0]) && $matches[1][0] != "timeline" ) {
						$success = array();
						$success["facebook"] = array("status" => "OK", "result" => $matches[1][0]);
						getLogger()->debug(" -> facebook success " . $matches[1][0]);
						print(json_encode($success));
					} else {
						$result = str_replace("https://www.facebook.com/","",$arr["responseData"]["results"][$key]["unescapedUrl"]);
						if( strpos($result, "?") > -1 ) {
							$result = substr($result, 0, strpos($result, "?"));
						}

						if( strpos($result, "https://pt-br.facebook.com/pages/") > -1 ) {
							$result = str_replace("https://pt-br.facebook.com/pages/","", $result);

							if( strpos($result, "/") > -1 ) {
								$result = substr($result, 0, strpos($result, "/"));
							}
						}

						if( strpos($result, "https://pt-br.facebook.com/") > -1 ) {
							$result = str_replace("https://pt-br.facebook.com/","", $result);

							if( strpos($result, "/") > -1 ) {
								$result = substr($result, 0, strpos($result, "/"));
							}
						}

						$success = array();
						$success["facebook"] = array("status" => "OK", "result" => $result);
						getLogger()->debug(" -> facebook success " . $result);
						print(json_encode($success));
					}	

				} else {
					$regex = '/(?:https?:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-\.]*)/';
					preg_match($regex, $arr["responseData"]["results"][0]["unescapedUrl"],$matches, PREG_OFFSET_CAPTURE, 3);
					if( isset($matches) && sizeof($matches) == 2 ) {
						$success = array();
						$success["facebook"] = array("status" => "OK", "result" => $matches[1][0]);
						getLogger()->debug(" -> facebook success " . $matches[1][0]);
						print(json_encode($success));
					} else {
						$result = str_replace("https://www.facebook.com/","",$arr["responseData"]["results"][0]["unescapedUrl"]);
						if( strpos($result, "?") > -1 ) {
							$result = substr($result, 0, strpos($result, "?"));
						}

						$success = array();
						$success["facebook"] = array("status" => "OK", "result" => $result);
						getLogger()->debug(" -> facebook success " . $result);
						print(json_encode($success));
					}
				}
				
			} else {
				$error = array();
				$error["facebook"] = array("status" => "ERROR", "message" => "result not found");
				getLogger()->debug(" -> facebook error for " . $query);
				print(json_encode($error));
			}

		}
	}

	function twitter() {
		$query = getParameter($_GET, "query");
		
		if( strpos($query, "-") > -1 ) {
			$query = substr($query, 0, strpos($query, "-") -1);
		}

		$query = strtolower($query);
		$query .= "+twitter";
		$url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=$query";
		
		$json = null;
		$arr = null;
		$check = 1;
		while( $arr === null || ( isset($arr["responseStatus"]) && $arr["responseStatus"] === 403 ) && $check < 5) {

			getLogger()->debug(" -> twitter call for " . $check++ . " time(s)");

			$json = file_get_contents($url);
			$arr = json_decode($json, TRUE);
			print_r($arr);

			if( isset($arr["responseData"]) && isset($arr["responseData"]["results"]) && sizeof($arr["responseData"]["results"]) > 1 ) {

				$result = str_replace("https://twitter.com/","",$arr["responseData"]["results"][0]["unescapedUrl"]);
				if( strpos($result, "?") > -1 ) {
					$result = substr($result, 0, strpos($result, "?"));
				}

				$success = array();
				$success["twitter"] = array("status" => "OK", "result" => $result);
				getLogger()->debug(" -> twitter success " . $result);
				print(json_encode($success));
				
			} else {
				$error = array();
				$error["twitter"] = array("status" => "ERROR", "message" => "result not found");
				getLogger()->debug(" -> twitter error for " . $query);
				print(json_encode($error));
			}

		}
	}

	// choose what method call
	$action = getParameter($_GET, "action");
	if( $action !== null ) {
		switch( $action ) {
			case "nearby":
				nearby();
				break;
			case "search":
				search();
				break;
			case "facebook":
				facebook();
				break;
			case "twitter":
				twitter();
				break;
			default:
				error();
				break;
		}
	}