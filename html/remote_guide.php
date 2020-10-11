<?php
/*******************************
leaderboard.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013
***********************************/

// requirements
require("../includes/config.php"); 

if($_SERVER["REQUEST_METHOD"] == "GET") {
	render("remote_guide_form.php"); 
}
else if($_SERVER["REQUEST_METHOD"] == "POST") {	
	apologize("Sorry, you can't post to the leaderboard. :("); 
	
}


?>