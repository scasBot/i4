<?php
/*******************************
inboxs.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

October 2014
***********************************/

define("LIMIT", 100);

// requirements
require("../includes/config.php");

if($_SESSION["id"] != 1718 && !ADMIN){
  redirect("/");
}

$query = "SELECT * FROM i3_Log INNER JOIN i3_Users ON i3_Log.UserID=i3_Users.UserID ORDER BY LastAction DESC LIMIT " . LIMIT;

$results = query($query);

render("logins_form.php", array("title" => "Logins", "logins" => $results));

?>
