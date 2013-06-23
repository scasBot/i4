<?php

	require("../includes/config.php"); 
	
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		// do stuff
	}
	else
	{
		apologize("You can't submit here :( Sorry"); 
	}

?>