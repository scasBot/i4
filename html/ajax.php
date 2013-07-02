<?php
	require("../includes/constants.php"); 
	require("../includes/functions.php"); 
	require("../includes/libraries/ALL.php"); 

	if($_SERVER["REQUEST_METHOD"] == "GET") {
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(!isset($_POST["REQ"])) {
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