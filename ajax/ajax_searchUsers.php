<?php
/*******************************
ajax_searchUsers.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description: 
	Supports the manage_users_form.php, ajax call to 
	search for users with certain criteria. 
***********************************/

define("LIMIT", 100); 

$query = "SELECT DISTINCT UserID, UserName, Email FROM i3_Users WHERE "; 

if(isset($data["hidden"])) {
	if($data["hidden"] == "false") {
		$query .= "Hidden=0 AND "; 
	}
}

if(isset($data["compers"])) {
	if($data["compers"] == "true") {
		$query .= "Comper=1 AND "; 		
	}
}

if(isset($data["yog"]) && $data["yog"] > 0) {
	$query .= " YOG=" . $data["yog"] . " AND "; 
}

if(isset($data["search"])) {
	$query .= "(LOWER(UserName) REGEXP '" . strtolower($data["search"]) . "' OR "
		. "LOWER(Email) REGEXP '" . strtolower($data["search"]) . "')"; 
}

$query .= " ORDER BY UserName";

$results = query($query); 

if(!$results) {
	die(); 
} else if(count($results) > LIMIT) {
	echo "1"; // too many results
	die(); 
} else {
	echo json_encode($results); 
	die(); 
}
?>