<?php

	// requirements
	require("../includes/config.php"); 

	if($_SERVER["REQUEST_METHOD"] == "GET") {
		apologize("Sorry, this page isn't ready yet."); 
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST") {	
		apologize("Sorry, you can't post to the leaderboard. :("); 
		
	}
?>