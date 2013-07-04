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
			else if ($key == "PhoneNumber") {
				$numbers = str_split(substr($value, 3)); 
				$string = ""; 
				foreach($numbers as $number) {
					$string .= "%" . $number; 
				}
			
				$rows = array_merge($rows, query(query_select(array("TABLE" => $table, "SELECT" => $select, 
					"WHERE" => array("Phone1AreaCode" => array("=", substr($value, 0, 3)), 
						"Phone1Number" => array("LIKE", $string)))))); 
			}
		}
		
		// render the list
		render("cases_list.php", 
			array("title" => "Find", 
					"cases" => $rows, 
					"addnew"=> $_POST)); 
	}
?>