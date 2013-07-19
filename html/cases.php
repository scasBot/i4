<?php

	require("../includes/config.php"); 
	require("../includes/client_class.php"); 
/*	
	$rows = query(query_select(array(
		"TABLE" => "dbi4_Contacts"))); 
		
	foreach($rows as $row) {
		$selected = query(query_select(array(
			"TABLE" => "dbi4_Priority", 
			"WHERE" => array("ClientID" => array("=", $row["ClientID"]))))); 
		
		if(!$selected) {
			$priority = new Priority(); 
			$priority->set("CaseTypeID", 0); 
			$priority->set("ClientID", $row["ClientID"]); 
			$priority->push(); 
		}
	}
*/	
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$rows1 = query(query_select(array(
			"TABLE" => "dbi4_Priority", 
			"WHERE" => array("CaseTypeID" => array("=", 1) )
		)));

		$rows2 = query(query_select(array(
			"TABLE" => "dbi4_Priority", 
			"WHERE" => array("CaseTypeID" => array("=", 21) )
		)));

		$rows3 = query(query_select(array(
			"TABLE" => "dbi4_Priority", 
			"WHERE" => array("CaseTypeID" => array("=", 22)), 
			"LIMIT" => 20
		)));
		
		$rows4 = query(query_select(array(
			"TABLE" => "dbi4_Priority", 
			"WHERE" => array("CaseTypeID" => array("=", 0) )
		)));

		$rows = array_merge($rows4, $rows1, $rows2, $rows3);
	
/*	
		$rows1 = query(query_select(array(
			"TABLE" => "dbi4_Contacts", 
			"ORDER" => array("ContactDate" => "DESC"), 
			"LIMIT" => 300))); 
		$rows2 = query(query_select(array(
			"TABLE" => "db_Contact", 
			"ORDER" => array("Date" => "DESC"), 
			"LIMIT" => 300))); 

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


		foreach($to_show as $key => $case) {
			try {
				$priority = new Priority($case["ClientID"]);  
			}
			catch(Exception $e) {
				$priority = new Priority(); 
				$priority->set("ClientID", $case["ClientID"]); 
				$priority->set("CaseTypeID", 0); 
				$priority->push();  
			}
			
			$to_show[$key]["Priority"] = $priority->get_description();
		}
*/
		$to_show = array(); 
		
		foreach($rows as $row) {
			$queried = query(query_select(array(
				"TABLE" => "db_Clients", 
				"SELECT" => array("FirstName", "LastName", "Phone1AreaCode", "Phone1Number", "Email"), 
				"WHERE" => array("ClientID" => array("=", $row["ClientID"]))
			))); 
			
			$queried[0]["Priority"] = unique_lookup("db_CaseTypes", $row["CaseTypeID"], 
				"CaseTypeID", "Description"); 	
		
			$to_show[] = $queried[0]; 			
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