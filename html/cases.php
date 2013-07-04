<?php

	require("../includes/config.php"); 
	
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$rows1 = query(query_select(array(
			"TABLE" => "dbi4_Contacts", 
			"ORDER" => array("ContactDate" => "DESC"), 
			"LIMIT" => 100))); 
		$rows2 = query(query_select(array(
			"TABLE" => "db_Contact", 
			"ORDER" => array("Date" => "DESC"), 
			"LIMIT" => 200))); 

		$rows = array_merge($rows1, $rows2); 
		
		function return_date($b) {
			if(isset($b["ContactDate"])) {
				return $b["ContactDate"]; 
			}
			else {
				return $b["Date"]; 
			}
		}
		
		$sort_func = create_function("\$a, \$b", 
			"return strtotime(return_date(\$b)) - strtotime(return_date(\$a));"); 
		usort($rows, $sort_func); 

		$clients = array(); 
		
		$dictionary = get_contact_types(); 
		
		// this is a list of all the urgent / needing help contact types
		$need_assistance = array(1, 21, 15, 10); 
		
		foreach($rows as $row) {
			if(!isset($clients[$row["ClientID"]])) {
				if(in_array($row["ContactTypeID"], $need_assistance)) {
					$clients[$row["ClientID"]] = true; 
				}
				else {
					$clients[$row["ClientID"]] = false; 
				}
			}
		}
		
		$to_show = array(); 
		
		foreach($clients as $id => $should_show) {
			if($should_show) {
				$to_show = array_merge($to_show, query(query_select(array(
					"TABLE" => "db_Clients", 
					"SELECT" => array("FirstName", "LastName", "Phone1AreaCode", "Phone1Number", "Email"), 
					"WHERE" => array("ClientID" => array("=", $id)))))); 
			}
		}

		render("cases_list.php", 
			array("title" => "By Priority", 
				"cases" => $to_show, 
				"addnew" => null)); 
	}
	else
	{
		apologize("You can't submit here :( Sorry"); 
	}

?>