<?php
	require("../includes/config.php"); 

	if($_SERVER["REQUEST_METHOD"] == "GET") {
		echo "Error : Can't request by get"; 
		die(); 
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
		
		switch($_POST["REQ"]) {
			case "contact" : 
				require("../ajax/ajax_contact.php"); 
			break;
			default : 
				echo "Error: REQ set incorrectly, " . $_POST["REQ"] . " does not exist."; 
			break; 
		}
	}
?>