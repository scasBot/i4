<?php
/*******************************
config.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

config.php and file structure taken from
CS50 PSET7 from Fall 2012

August 2013

Description : 
	This needs to be required by EVERY SINGLE PAGE!
	It's the global handler that requires all of the functions and 
	constants etc., 
***********************************/

// constants first
require("constants.php");

// error reporting
ini_set("display_errors", true);
if(LOCAL_HOST) {
	// everything displayed
	error_reporting(E_ALL | E_STRICT);
} else {
	// fatal errors and parse errors
	error_reporting(E_ERROR | E_PARSE);
}

// requirements
require("constants_passwords.php"); 
require("trolling.php");
require("libraries/ALL.php");
require("functions_navigation.php");
require("functions_database.php"); 
require("magic_quotes_emulate.php"); 

// enable sessions
session_start();

// require authentication for most pages
if (!preg_match("{(?:login|logout|register|email)\.php$}", $_SERVER["PHP_SELF"])) {

	// id shows whether or not a user has been logged in 
	if (empty($_SESSION["id"])) {
		redirect("login.php");
	} else {
		define("LOGGED_IN", true); 
		define("COMPER", is_comper($_SESSION["id"])); 
		define("ADMIN", is_admin($_SESSION["id"])); 
	}
} else {
	define("LOGGED_IN", false); 
}
?>
