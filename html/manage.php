<?php
/*******************************
manage.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : 
Useful for admin (tech, executives) to manage
different compers and users
***********************************/
require("../includes/config.php"); 
require("../includes/profile_class.php"); 

if(!ADMIN) {
	redirect(ROOT_PUBLIC); 
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
	if(!isset($_GET["type"])) {
		apologize("Please request a type of management."); 
	}

	switch ($_GET["type"]) {
		case "users" : 
			render("manage_users_form.php", array("title" => "Manage")); 
		break; 
		case "user" : 
			if(!isset($_GET["UserID"])) {
				apologize("Must input a user id.");
			}
			try {
				$user = new Profile($_GET["UserID"]); 
				$cases = model("cases_by_user.php", array("UserID" => $_GET["UserID"]));
				$stats = model("user_stats.php", array("UserID" => $_GET["UserID"]));  				
				
				render("profile_form.php", array("title" => "Manage", 
					"user" => $user->get_array(), 
					"cases" => $cases, 
					"stats" => $stats, 
					"ADMIN_EDIT" => true, 
					"user_is_admin" => is_admin($_GET["UserID"]), 
					"user_is_comper" => is_comper($_GET["UserID"]))); 
			} catch (Exception $e) {
				apologize("Sorry, getting the profile failed: " . $e->getmessage()); 
			}
		break;
		default : 
			apologize("Sorry, that type of management doesn't exist."); 
		break; 
	}
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	apologize("Can't post here."); 
}
?>