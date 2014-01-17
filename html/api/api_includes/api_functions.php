<?php

/**********
* Allow CORS access requests
* http://www.w3.org/TR/cors/
***********/
function cors() {
	header("Access-Control-Allow-Origin: *");
}

/*****
* Global API error handler
******/
function error($msg = NULL) {
	if ($msg) {
		echo "Error: " . $msg; 
	} else {
		echo "0"; 
	}	
	die(); 
}

/******
* To require shared resources with the main website
******/
function require_from_main($str) {
	require("../../includes/" . $str); 
}

?>