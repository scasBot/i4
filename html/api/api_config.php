<?php
/*******************************
api_config.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

January 2014

Description : 
	This needs to be required by EVERY SINGLE PAGE of the API!
	It's the global handler that requires all of the functions and 
	constants etc., 
***********************************/
// because the included files aren't in the same folder anymore
define("INCLUDE_ROOT", "../../includes/");
function require2($str) {
	require(INCLUDE_ROOT . $str); 
}

function error($msg = NULL) {
	if ($msg) {
		echo "Error: " . $msg; 
	} else {
		echo "0"; 
	}	
	die(); 
}

// constants first
require2("constants.php");

// error reporting
if(LOCAL_HOST) {
	ini_set("display_errors", true);
	error_reporting(E_ALL | E_STRICT);
} else {
	ini_set("display_errors", false); 
}

// requirements
require2("constants_passwords.php"); 
require2("libraries/ALL.php");
require2("functions_database.php"); 
require2("magic_quotes_emulate.php");

// CORS 
header("Access-Control-Allow-Origin: *");

// check request method
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$data = $_POST;
} else if($_SERVER["REQUEST_METHOD"] == "GET") {
	$data = $_GET; 
} else {
	error("Bad request method"); 
}
?>