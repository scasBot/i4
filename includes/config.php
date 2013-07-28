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

// display errors, warnings, and notices
ini_set("display_errors", true);
error_reporting(E_ALL);

// requirements
require("trolling.php");
require("constants.php");
require("functions_navigation.php");
require("functions_database.php");
require("libraries/ALL.php"); 
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
	}
} else {
	define("LOGGED_IN", false); 
}
?>
