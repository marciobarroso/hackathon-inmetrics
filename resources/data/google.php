<?php

	// all responses must be an XML
	// header('Content-type: application/xml');

	$GOOGLE_API_KEY = "AIzaSyA0t4XNY5bRhgy1SWPXbWjyCTJsqybFRHs";

	function search() {
		$query = $_GET["query"];
		$latitude = $_GET["query"];
	}

	print_r($_GET);