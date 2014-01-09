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
require("../includes/mailer_class.php"); 

// both GET and POST means the request method is correct
if($_SERVER["REQUEST_METHOD"] == "GET") {
	if(ADMIN && isset($_GET["ResetPassword"])) {
		if(!isset($_GET["UserID"])) 
			apologize("Must give a user id."); 
		else {
			$new_password =  get_randomword(); 
			$password = new Password($_GET["UserID"]); 
			$password->set("hash", crypt($new_password)); 
			$password->push(); 
			
			$profile = new Profile($_GET["UserID"]); 
			$mailer = new Mailer(); 
			$mailer->to($profile->get("Email")); 
			$mailer->from("scasBot@masmallclaims.org"); 
			$mailer->subject("i4 Password Reset"); 
			$mailer->message("Your password for i4.masmallclaims.org has recently been reset to " . $new_password 
				. ". Please login now and change it."); 
			$mailer->send();
			redirect("manage.php?type=user&UserID=" . $_GET["UserID"]); 
		}
	} else if (ADMIN && isset($_GET["MakeAdmin"])) {
		if(!isset($_GET["UserID"])) 
			apologize("Must give a user id."); 
		else {
			query("INSERT INTO i3_Admins SET UserID=?", $_GET["UserID"]); 
		}
		redirect("manage.php?type=user&UserID=" . $_GET["UserID"]); 
	} else if(ADMIN && isset($_GET["RevokeAdmin"])) {
		if(!isset($_GET["UserID"])) 
			apologize("Must give a user id."); 
		else {
			query("DELETE FROM i3_Admins WHERE UserID=? LIMIT 1", $_GET["UserID"]); 
		}	
		redirect("manage.php?type=user&UserID=" . $_GET["UserID"]); 		
	}

	$profile = new Profile($_SESSION["id"]); 
	render("profile_form.php", array("title" => "Profile", 
		"user" => $profile->get_array(), 
		"user_is_admin" => ADMIN));		
} else if($_SERVER["REQUEST_METHOD"] == "POST") {	
	if(ADMIN) {
		if(!isset($_POST["UserID"]))
			apologize("Must give a user id. If this is an error, please contact " . ADMIN_EMAIL); 
		$id = $_POST["UserID"];
		$self = true; 
	} else {
		$id = $_SESSION["id"]; 
		if($_POST["NewPassword"]) {
			$password = new Password($id); 
			$user = $password->get_array();	
		
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
	}

	// if POSTing, then edit the profile and push
	$profile = new Profile($id);	
	$profile->from_array($_POST); 
	$profile->push(); 

	if(isset($self))
		redirect("manage.php?type=user&UserID=" . $_POST["UserID"]); 					
	else 
		redirect("profile.php"); // so that it doesn't post multiple times
}
?>