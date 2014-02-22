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

require("api_functions.php"); 

// allow CORS
cors(); 

// constants first
require_from_main("constants.php");

// error reporting
if(LOCAL_HOST) {
	ini_set("display_errors", true);
	error_reporting(E_ALL | E_STRICT);
} else {
	ini_set("display_errors", false); 
}

// requirements
require_from_main("constants_passwords.php"); 
require_from_main("libraries/ALL.php");
require_from_main("functions_database.php"); 
require_from_main("magic_quotes_emulate.php");

switch($_SERVER["REQUEST_METHOD"]) {
	case "POST" : 
		$data = $_POST; 
		break; 
	case "GET" : 
		$data = $_GET; 
		break; 
	default : 
		error("Bad request method."); 
}

require("authorization.php"); 
?>