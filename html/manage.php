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
		case "compers" : 
			render("manage_compers_form.php", array("title" => "Manage")); 
		break; 
		case "users" : 
			render("manage_users_form.php", array("title" => "Manage")); 
		break; 
		default : 
			apologize("Sorry, that type of management doesn't exist."); 
		break; 
	}
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
}
?>