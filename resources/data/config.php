<?php

	// SET TO PRD OR DEV
	define("PRODUCTION","PRODUCTION");
	define("DEVELOPMENT","DEVELOPMENT");
	define("TRUE", "TRUE");
	define("FALSE", "FALSE");
	define("CONFIG_GOOGLE_API_KEY_DEV","AIzaSyDm743hCy0maE2farUjk4C24_udd5cLaXs");
	define("CONFIG_GOOGLE_API_KEY_PRD","AIzaSyAozbpxXqq81tPUOjCEIVpkoPtGYxwUQXk");


	// CHANGE HERE
	define("CONFIG_ENVIRONMENT", PRODUCTION);
	//define("CONFIG_DEBUG", CONFIG_ENVIRONMENT === PRODUCTION ? FALSE : TRUE);
	define("CONFIG_DEBUG", FALSE);

	// constants for APIS
	define("CONFIG_GOOGLE_API_KEY", CONFIG_ENVIRONMENT === PRODUCTION ? CONFIG_GOOGLE_API_KEY_PRD : CONFIG_GOOGLE_API_KEY_DEV);
	
	// enable error messages
	if( CONFIG_DEBUG === TRUE ) {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		define("CONFIG_HTTP_PROTOCOL", strpos($_SERVER["SERVER_PROTOCOL"], "HTTPS") > -1 ? "https" : "http");
		define("CONFIG_SERVER_PREFIX", CONFIG_HTTP_PROTOCOL . "://" . $_SERVER["HTTP_HOST"]);
	}