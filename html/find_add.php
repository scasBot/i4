<?php
	require("../includes/config.php"); 
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
			// do stuff
	}
	else
	{
		render("find_add_form.php", array("title" => "Find/Add Client")); 
	}
?>