<?php
	require("../includes/config.php"); 
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$table = "db_Clients"; 
		$to_select = array("ClientID", "LastName", "FirstName", "Email", "Phone1AreaCode", "Phone1Number"); 
		$where = array("FirstName" => array("=", "Michael")); 
		$order = array("LastName" => "ASC"); 	
		$rows = query_select(array("TABLE" => $table, "TO_SELECT" => $to_select, "WHERE" => $where, "ORDER" => $order)); 
		
		if(count($rows) > 0)
		{
			render("cases_list.php", array("title" => "Find", "cases" => $rows, "addnew"=> $_POST)); 
		}
		else
		{
			render("add_new_client.php", array("title" => "No Matches", "info" => $_POST)); 
		}
	}
	else
	{
		render("find_add_form.php", array("title" => "Find/Add Client")); 
	}
?>