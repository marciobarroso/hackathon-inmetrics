<?php

	// SET TO PRD OR DEV
	define("CONFIG_ENVIRONMENT", "DEV");
	define("CONFIG_DEBUG", CONFIG_ENVIRONMENT === "PRD" ? false : true);

	// constants for APIS
	define("CONFIG_GOOGLE_API_KEY", CONFIG_ENVIRONMENT === "PRD" ? "AIzaSyAozbpxXqq81tPUOjCEIVpkoPtGYxwUQXk" : "AIzaSyDm743hCy0maE2farUjk4C24_udd5cLaXs");
	
	// enable error messages
	if( CONFIG_ENVIRONMENT !== "PRD" ) {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		define("CONFIG_HTTP_PROTOCOL", strpos($_SERVER["SERVER_PROTOCOL"], "HTTPS") > -1 ? "https" : "http");
		define("CONFIG_SERVER_PREFIX", CONFIG_HTTP_PROTOCOL . "://" . $_SERVER["HTTP_HOST"]);
	}