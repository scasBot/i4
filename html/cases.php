<?php

	require("../includes/config.php"); 
	require("../includes/client_class.php"); 
	
	// this is really slow algorithmically, but it should be limited to a good amount....so....
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if($_GET["type"] == "priority") {
			function get_by_priority_id($id) {
				return query(query_select(array(
				"TABLE" => "dbi4_Priority", 
				"WHERE" => array("CaseTypeID" => array("=", $id))
				))); 
			}
			
			$urgent = get_by_priority_id(1); 
			$message_left = get_by_priority_id(22); 
			$no_contacted = get_by_priority_id(21); 
			$undefined = get_by_priority_id(0); 
			$phone_tag = get_by_priority_id(11); 

			$rows = array_merge($undefined, $urgent, $no_contacted, $phone_tag, $message_left);
			
		} else if ($_GET["type"] == "date") {
			$rows = query(query_select(array(
				"TABLE" => "dbi4_Contacts",
				"SELECT" => "ClientID", 
				"ORDER" => array("ContactDate" => "DESC"), 
				"LIMIT" => 100
			))); 

			$taken = array(); 
			
			foreach($rows as $key => $row) {
				if(!isset($taken[$row["ClientID"]])) {
					$priority = new Priority($row["ClientID"]); 
					$taken[$row["ClientID"]] = ""; 
					$rows[$key]["CaseTypeID"] = $priority->get("CaseTypeID"); 
				} else {
					unset($rows[$key]); 
				}
			}
		} else {
			apologize("Can't access cases like that."); 
		}

		$to_show = array(); 
		$priorities = get_priorities(); 
			
		foreach($rows as $row) {
			$queried = query(query_select(array(
				"TABLE" => "db_Clients", 
				"SELECT" => array("FirstName", "LastName", "Phone1AreaCode", "Phone1Number", "Email"), 
				"WHERE" => array("ClientID" => array("=", $row["ClientID"]))
			))); 
		
			$queried[0]["Priority"] = $priorities[$row["CaseTypeID"]]; 		
			$to_show[] = $queried[0]; 			
		}
			
		render("cases_list.php", 
			array("title" => "By Priority", 
				"cases" => $to_show, 
				"addnew" => null)); 
	} else {
		apologize("You can't submit here :( Sorry"); 
	}

?>