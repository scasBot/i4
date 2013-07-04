<?php
	require("../includes/config.php"); 
	
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		
		if(isset($_GET["SHOW_LIST"])) {
			search($_GET); 
			die(); 
		}
		
		render("find_add_form.php", array("title" => "Find/Add Client")); 
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST") { 
		search($_POST); 
		die(); 
	}

function search($info) {
		$table = "db_Clients"; 
		$select = array("FirstName", "LastName", "Phone1AreaCode", "Phone1Number", "Email"); 
		$rows = array(); 
		
		foreach($info as $key => $value) {
			if($value !== "" && $key != "SHOW_LIST") {
				if($key != "PhoneNumber") {
					$rows = array_merge($rows, query(query_select(array("TABLE" => $table, "SELECT" => $select, 
						"WHERE" => array($key => array("=", $value))))));
				}
				else if ($key == "PhoneNumber") {
					$value = only_numbers($value); 
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
		}
		
		// render the list
		render("cases_list.php", 
			array("title" => "Find", 
					"cases" => $rows, 
					"addnew"=> $info));
}
?>