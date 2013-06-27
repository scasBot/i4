<?php

	require("../includes/config.php"); 
	
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$table = "i3_Users"; 
		$where = array("UserID" => array("=", $_SESSION["id"])); 
		
		$rows = query(query_select(array("TABLE" => $table, "WHERE" => $where))); 
		 
		if(count($rows) == 1)
		{
			render("profile_form.php", array("title" => "Profile", "user" => $rows[0])); 
		}
		else
		{
			apologize("Sorry, something's wrong with the database."); 
		}
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		render("profile_form.php", array("title" => "Profile", "user" => $rows[0])); 
	}
		
?>