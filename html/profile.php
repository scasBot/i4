<?php
/*******************************
profile.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : 
	Profile information about each i4 user 
	from i3_Users database
***********************************/
require("../includes/config.php"); 
require("../includes/profile_class.php"); 

$profile = new Profile($_SESSION["id"]); // the profile object contains all operations

// both GET and POST means the request method is correct
if($_SERVER["REQUEST_METHOD"] == "GET") {
	render("profile_form.php", array("title" => "Profile", 
		"user" => $profile->get_array()));		
}
else if($_SERVER["REQUEST_METHOD"] == "POST") {	
	// if POSTing, then edit the profile and push
	$profile->from_array($_POST); 
	$profile->push(); 
	
	$password = new Password($_SESSION["id"]); 
	$user = $password->get_array();	
	if($_POST["NewPassword"]) {
		if(crypt($_POST["CurrentPassword"], $user["hash"]) != $user["hash"]) {
			apologize("Incorrect current password. Password not changed, all other " . 
				"profile stats updated."); 
		} else if($_POST["NewPassword"] != $_POST["ConfirmPassword"]) {
			apologize("Sorry, new password and confirmation don't match. " . 
				"Password not changed, all other profile stats updated."); 
		} else {
			$password->set("hash", crypt($_POST["NewPassword"])); 
			$password->push(); 
		}
	}
	
	redirect("profile.php"); // so that it doesn't post multiple times
}
?>