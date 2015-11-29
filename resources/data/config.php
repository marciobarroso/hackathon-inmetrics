<?php

	// start session
	if (session_status() == PHP_SESSION_NONE) {
    	session_start();	
	}

	// SET TO PRD OR DEV
	define("TRUE", "TRUE");
	define("FALSE", "FALSE");

	// CHANGE HERE
	define("CONFIG_DEBUG", FALSE);

	// enable error messages
	if( CONFIG_DEBUG === TRUE ) {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		define("CONFIG_HTTP_PROTOCOL", strpos($_SERVER["SERVER_PROTOCOL"], "HTTPS") > -1 ? "https" : "http");
		define("CONFIG_SERVER_PREFIX", CONFIG_HTTP_PROTOCOL . "://" . $_SERVER["HTTP_HOST"]);
	}

	define("CONFIG_GOOGLE_API_APP_CLIENT_ID", "510002317093-d22ispdb67db3qsp0umfjfrggbo6s243.apps.googleusercontent.com");
	define("CONFIG_GOOGLE_API_APP_CLIENT_SECRET", "x5cctYVwfpQifLkHygpkWWfB");

	$GOOGLE_API_KEYS = array(
		"AIzaSyA8zjLueGVxqsnPCVvv_2lU6bG1yf1QOcI",
		"AIzaSyDm743hCy0maE2farUjk4C24_udd5cLaXs",
		"AIzaSyAozbpxXqq81tPUOjCEIVpkoPtGYxwUQXk"
	);

	$choosed = $GOOGLE_API_KEYS[array_rand($GOOGLE_API_KEYS)];

	define("CONFIG_GOOGLE_API_KEY", $choosed);

	function getParameter($context, $name) {
		if( isset($context) && isset($context[$name]) ) {
			$result = $context[$name];
			$result = str_replace(" ","+", $result);
			return $result;
		} else {
			return null;
		}
	}

	// configure log4php 
	include($_SERVER['DOCUMENT_ROOT'] . "/vendors/log4php/Logger.php");
	
	function getLogger() {
		Logger::configure($_SERVER['DOCUMENT_ROOT'] . "/resources/data/log4php-config.xml");
		$CONFIG_LOGGER = Logger::getLogger("main");
		return $CONFIG_LOGGER;
	}
