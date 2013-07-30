<?php
/*******************************
find_add.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : handler for the find_add form
and contains the search function of this website
***********************************/
require("../includes/config.php"); 
require("../includes/client_class.php"); 

if ($_SERVER["REQUEST_METHOD"] == "GET") {

	/* GET request used for search (like google)
		so that when users click the back button
		they don't have to confirm resubmitting form */
	if(isset($_GET["SHOW_LIST"])) {
		search($_GET); // this function below
		die(); 
	} else { // otherwise render the search form
		render("find_add_form.php", array("title" => "Find/Add Client")); 
	}
// still allow POST requests for search, no reason to do this though
} else if($_SERVER["REQUEST_METHOD"] == "POST") { 
	search($_POST); 
	die(); 
}

/* main function for this page that performs the search 
	function and renders the clients. Currently everything is <or> and not <and> */
function search($info) { // $info is all items in a $_GET or $_POST request
	$table = "db_Clients"; 
	$select = array("FirstName", "LastName", "Phone1AreaCode", "Phone1Number", "Email"); // items that are to be displayed

	$rows = array(); // will hold all the cases in the end
	foreach($info as $key => $value) {
		// avoid empty elements and the SHOW_LIST get request
		if($value !== "" && $key != "SHOW_LIST") { // potential security flaw
			if($key != "PhoneNumber") { // everything but phone numbers can be directly accessed
				$rows = array_merge($rows, 
					query(query_select(array("TABLE" => $table, "SELECT" => $select, 
					"WHERE" => array($key => array("=", $value))))));
			} else if ($key == "PhoneNumber") {
					// phonenumber is annoying because db_Clients shows areacode and then number
				$value = only_numbers($value); 
				$numbers = str_split(substr($value, 3)); 
				$string = ""; 
				foreach($numbers as $number) {
					$string .= "%" . $number; 
				}
			
				$rows = array_merge($rows, 
					query(query_select(array("TABLE" => $table, "SELECT" => $select, 
					"WHERE" => array("Phone1AreaCode" => array("=", substr($value, 0, 3)), 
						"Phone1Number" => array("LIKE", $string)))))); 
			}
		}
	}
	
	// now we need the priorities for each client too
	foreach($rows as $key => $row) {
		try {
			$priority = new Priority($row["ClientID"]);  
		} catch (Exception $e) {
				/* exception is triggered if the client doesn't have a priority
					so then we have to make a new one */
			$priority = new Priority(); 
			$priority->set("ClientID", $row["ClientID"]); 
			$priority->set("CaseTypeID", 0); // 0 means "undefined" priority
			$priority->push(); 
		}
		
		$rows[$key]["Priority"] = $priority->get_description();
	}
	
	// render the list
	render("cases_list.php", 
		array("title" => "Find", 
				"cases" => $rows, 
				"addnew"=> $info)); // also give the option to add a new client
}
?>