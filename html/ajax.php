<?php
/*******************************
ajax.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : ajax.php is the global
handler for all ajax requests to the scas website. 
Go to i4/html/js/ajaxBot.js to see how it is used. 
***********************************/

require("../includes/config.php"); 
define("AJAX_ROOT", "../ajax/"); 	

// global error handling for all ajax pages, doesn't do much now
function ajax_error($string) {
	return "Error: " . $string; 
}

/* used to require the necessary ajax_handlers
	file structure for all handlres is "../ajax/ajax_NAME.php */
function ajax_handler($req) {
	return AJAX_ROOT . "ajax_" . $req . ".php"; 
}

if($_SERVER["REQUEST_METHOD"] == "GET") {

	// require authentication
	if(!isset($_GET["hash"])) { // must provide a hash
		echo "Error: Unauthorized access."; 
		die(); 
	} else if ($_GET["hash"] !== AJAX_HASH) { // hash must match the AJAX_HASH
		echo "Error: Incorrect hash authentication"; 
		die(); 
	} else if(!isset($_GET["REQ"])) { // must request a specific page
		echo "Error: REQ not set"; 
		die(); 
	}

	// must be authenticated, so allow the handlers to be called
	switch($_GET["REQ"]) {
		case "gmailGadget" : 
			require(ajax_handler($_GET["REQ"])); 
		break; 
		default: 
			echo "Error: REQ set incorrectly, " . $_GET["REQ"] . " doees not exist."; 
		break; 
	}

} else if($_SERVER["REQUEST_METHOD"] == "POST") {

	// require authentication
	if(!isset($_POST["auth"])) { // must have authorization variable
		echo "Error: Unauthorized Request"; 
		die(); 
	} else if (!isset($_POST["auth"]["id"]) || $_POST["auth"]["hash"] != AJAX_HASH) { // both id and AJAX_HASH must be provided correctly 
		echo "Error: Authorization incorrect"; 
		die(); 
	} else if(!isset($_POST["REQ"])) { // the ajax request has to ask for a specific page
		echo "Error: REQ not set"; 
		die(); 
	}

	$id = $_POST["auth"]["id"]; // because no cookies are requested, $_SESSION["id"] is instead stored in $id, 
	/* NOTE: The id method is a security flaw, another method potentially is to match id with hash */
	$data = $_POST["data"];  // data can be extracted to by the handlers
	
	// return the required page
	switch($_POST["REQ"]) {
		case "contact" : 
		case "emailForm" : 
		case "clientEmails" : 
			require(ajax_handler($_POST["REQ"])); 
		break;
		default : 
			echo "Error: REQ set incorrectly, " . $_POST["REQ"] . " does not exist."; 
		break; 
	}
}
?>