<?php
	require("../includes/config.php"); 
	
	if ($_SERVER["REQUEST_METHOD"] == "GET") {

		render("find_add_form.php", array("title" => "Find/Add Client")); 
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST") {

		$table = "db_Clients"; 
		$select = array("FirstName", "LastName", "Phone1AreaCode", "Phone1Number", "Email"); 
		$rows = array(); 
		
		foreach($_POST as $key => $value) {
			if($key != "PhoneNumber" && $value != "") {
				$rows = array_merge($rows, query(query_select(array("TABLE" => $table, "SELECT" => $select, 
					"WHERE" => array($key => array("=", $value))))));
			}
		}
		
		// render the list
		render("cases_list.php", 
			array("title" => "Find", 
					"cases" => $rows, 
					"addnew"=> $_POST)); 
	}
?>