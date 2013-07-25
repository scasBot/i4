<?php
	require("../includes/config.php"); 
	
	define("AJAX_ROOT", "../ajax/"); 
	
	function ajax_error($string) {
		return "Error: " . $string; 
	}
	function ajax_page($page) {
		return AJAX_ROOT . "ajax_" . $page . ".php"; 
	}
	
	if($_SERVER["REQUEST_METHOD"] == "GET") {

		// require authentication
		if(!isset($_GET["hash"])) {
			echo "Error: Unauthorized access."; 
			die(); 
		} else if ($_GET["hash"] !== AJAX_HASH) {
			echo "Error: Incorrect hash authentication"; 
			die(); 
		} else if(!isset($_GET["REQ"])) { // require REQuested page
			echo "Error: REQ not set"; 
			die(); 
		}
	
		// return the required page
		switch($_GET["REQ"]) {
			case "gmailGadget" : 
				require(ajax_page($_GET["REQ"])); 
			break; 
			default: 
				echo "Error: REQ set incorrectly, " . $_GET["REQ"] . " doees not exist."; 
			break; 
		}
	
	} else if($_SERVER["REQUEST_METHOD"] == "POST") {

		// require authentication
		if(!isset($_POST["auth"])) {
			echo "Error: Unauthorized Request"; 
			die(); 
		} else if (!isset($_POST["auth"]["id"]) || $_POST["auth"]["hash"] != AJAX_HASH) { 
			echo "Error: Authorization incorrect"; 
			die(); 
		} else if(!isset($_POST["REQ"])) { // require REQuested page
			echo "Error: REQ not set"; 
			die(); 
		}
		
		$data = $_POST["data"]; 
		
		// return the required page
		switch($_POST["REQ"]) {
			case "contact" : 
			case "emailForm" : 
				require(ajax_page($_POST["REQ"])); 
			break;
			default : 
				echo "Error: REQ set incorrectly, " . $_POST["REQ"] . " does not exist."; 
			break; 
		}
	}
?>