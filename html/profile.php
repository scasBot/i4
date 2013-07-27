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
$correct_req = false; // variable to check if the request method is correct

// both GET and POST means the request method is correct
if($_SERVER["REQUEST_METHOD"] == "GET") {
	$correct_req = true;
}
else if($_SERVER["REQUEST_METHOD"] == "POST") {	
	$correct_req = true; 
	
	// if POSTing, then edit the profile and push
	$profile->from_array($_POST); 
	$profile->push(); 
}

if($correct_req) {
	render("profile_form.php", array("title" => "Profile", "user" => $profile->get_array()));		
} else {
	apologize("Incorrect request method."); 
}
?>