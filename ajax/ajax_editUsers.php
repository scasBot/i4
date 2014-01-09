<?php
/*******************************
ajax_editUsers.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description: 
***********************************/

// using contact class
require("../includes/profile_class.php"); 

if(!isset($data["type"])) {
	ajax_error("No type defined"); 
	die(); 
}

switch ($data["type"]) {
	case "list" : 
		if(!ADMIN) {
			ajax_error("Not an administrator"); 
			die(); 
		}
	
		if(!isset($data["action"], $data["users"]) || count($data["users"]) == 0) {
			ajax_error("Missing data parameters"); 
			die(); 
		} else {
			foreach($data["users"] as $user_id) {
				$profile = new Profile($user_id);
				switch ($data["action"]) {
					case "graduate" : 
						$profile->set("Comper", 0); 
					break; 
					case "ungraduate" : 
						$profile->set("Comper", 1); 
					break; 
					case "hide": 
						$profile->set("Hidden", 1); 
					break; 
					case "unhide": 
						$profile->set("Hidden", 0); 
					break; 
					default: 
						ajax_error("Wrong action"); 
						die(); 
				}
				$profile->push(); 
			}
			die(); 
		}
	break; 
}
?>
