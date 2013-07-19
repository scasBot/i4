<?php

	require("../includes/config.php"); 
	require("../includes/profile_class.php"); 
	
	$profile = new Profile($_SESSION["id"]); 
	$correct_req = false; 
	
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		$correct_req = true; 
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST") {	
		$correct_req = true; 
		
		$profile->from_array($_POST); 
		$profile->push(); 
	}
	
	if($correct_req) {
		render("profile_form.php", array("title" => "Profile", "user" => $profile->get_array()));		
	}
	else {
		apologize("Incorrect request method."); 
	}
?>