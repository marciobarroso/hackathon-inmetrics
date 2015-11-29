<?php

	include "config.php";

	// all responses must be an JSON
	header('Content-Type: text/json');

	$action = getParameter($_GET, "action");
	if( $action !== null ) {
		switch( $action ) {
			case "info":
				info();
				break;
		}
	}

	function info() {
		$info = array();
		$info["ranktoon"] = array();
		$info["ranktoon"]["status"] = "OK";
	}