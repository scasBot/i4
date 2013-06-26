<?php
	
	require("../includes/config.php"); 
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		render("client_form.php", array("title" => "Client"));  
	}
	else
	{
		apologize("Sorry, have to post here"); 
	}

?>