<?php
/*******************************
inbox.php

By: Keon Chris Lim
klim01@college.harvard.edu

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

January 2014
***********************************/

// requirements
require("../includes/config.php"); 

$query = "SELECT * FROM db_Emails WHERE isAssigned = 0 ORDER BY timestamp";

$results = query($query);

render("inbox_form.php", array("title" => "Inbox", "mail" => $results));


?>
