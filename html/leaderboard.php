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
	$json_stats = file_get_contents(LEADERBOARD_STATS_FILE); 
	$stats = json_decode($json_stats, true);
	render("leaderboard_form.php", array("title" => "Leaderboard", "stats" => $stats)); 
}
else if($_SERVER["REQUEST_METHOD"] == "POST") {	
	apologize("Sorry, you can't post to the leaderboard. :("); 
	
}


?>