<?php
/*******************************
login.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : login handler, first page
that people will see on the site
***********************************/
// configuration
require("../includes/config.php"); 

// if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// validate submission
	if (empty($_POST['UserName'])) {
		apologize("You must provide your username.");
	} else if (empty($_POST["password"])) {
		apologize("You must provide your password.");
	}

	// query database for user
	$rows = query("SELECT * FROM i3_Passwords INNER JOIN i3_Users " 
		. "ON i3_Users.UserID=i3_Passwords.UserID WHERE `UserName`=? AND Hidden=0", $_POST["UserName"]);
	$user = query("SELECT 'UserID', `UserName`, `Email` FROM i3_Users WHERE `UserName`=? AND Hidden=0", $_POST['UserName']); 
	
	// if we found user, check password
	if (count($rows) > 0) {

		// first (and only) row
		$row = $rows[0];

		// compare hash of user's input against hash that's in database
		if (crypt($_POST["password"], $row["hash"]) == $row["hash"]) {

			// remember that user's now logged in by storing information in SESSION, id is used
			// to check login now
			$_SESSION["id"] = $row["UserID"];
			$_SESSION["username"] = $user[0]["UserName"]; 
			$_SESSION["useremail"] = $user[0]["Email"]; 
			$_SESSION["logid"] = set_i3_log(); 

			// redirect to home
			redirect(ROOT_PUBLIC);
		}
	}

	// else apologize
	apologize("Invalid username and/or password.");
}
else { // must be a $_GET request

	// get all the users to display in dropdown and render form
	$rows = query("SELECT `UserName` " . 
		"FROM `i3_Users` WHERE `hidden`=0 ORDER BY `UserName` DESC"); 
	render("login_form.php", array("users" => $rows));
}
?>
