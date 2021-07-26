<?php
/*******************************
users.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails.

January 2014

Description : Displays all the users of the i4
***********************************/
require("../includes/config.php");

switch ($_SERVER["REQUEST_METHOD"]) {
	case "POST":
		apologize("Can't access that way yet.");
		break;
	case "GET":
		$query = "SELECT UserID, UserName, Email, YOG "
			. "FROM i3_Users "
			. "WHERE Hidden=0 "
			. "ORDER BY YOG ASC, UserName ASC " ;
		$users = query($query);
		render("users_list.php", array("title" => "i4 Users",
			"users" => $users));
		break;
	default:
		apologize("Wrong access type.");
		break;
}
?>