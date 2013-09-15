<?php
require("../includes/config.php"); 
require("../includes/profile_class.php"); 

if ($_SERVER["REQUEST_METHOD"] == "GET") {
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {	
	if(empty($_POST["YOG"]) || empty($_POST["UserName"]) || 
		!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
		apologize("Sorry, information you entered was incorrect."); 
	}		

	$comper = new Profile(); 	
	$comper->from_array($_POST);
	$comper->set("Comper", 1); 
	$comper->set("Hidden", 0); 
	$comper->push(); 
	
	$password = new Password();
	$password->set("UserID", $comper->get_id()); 
	$password->set("hash", crypt("SCAS1965")); 
	$password->push(); 
}

render("add_user_form.php", array(
	"title" => "New Comper", 
)); 