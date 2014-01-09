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

function insert_between_each_char($str, $between) {
	$string = ""; 
	$str = str_split($str); 
	
	foreach($str as $c) {
		$string .= $between . $c; 
	}
	
	return $string . $between; 
}

function kv_fun($key, $value) {
	return "$key LIKE '$value'"; 
}


/* main function for this page that performs the search 
	function and renders the clients. Currently everything is <or> and not <and> */
function search($info) { // $info is all items in a $_GET or $_POST request
	$table = "db_Clients"; 
	$keys = array("ClientId", "FirstName", "LastName", "PhoneNumber", "Email"); 
	$query_arr = array(); 
	$phone_query = ""; 
	$rows = array(); // will hold all the cases in the end

	foreach($keys as $key) {
		if(!empty($info[$key]) && $key != "PhoneNumber")
			$query_arr[$key] = $info[$key]; 
		else if(!empty($info[$key]) && $key == "PhoneNumber") {
			$value = only_numbers($info[$key]); 
			$phone_query = "(`Phone1AreaCode`='" . substr($info[$key], 0, 3) . 
				"' AND `Phone1Number` LIKE '" . insert_between_each_char(substr($info[$key], 3), "%") . "')"; 			
		}
	}
	
	// query string
	$query = "SELECT $table.*, db_CaseTypes.Description as Priority "
		. "FROM $table INNER JOIN db_CaseTypes ON db_CaseTypes.CaseTypeID=db_Clients.CaseTypeID WHERE "; 
	
	$query .= arr_to_str("kv_fun", " OR ", "", $query_arr) 
		. (count($query_arr) > 0 && $phone_query != "" ? " OR " : "" ). $phone_query; 
	
	$rows = query($query); 
	
	// render the list
	render("cases_list.php", 
		array("title" => "Find", 
				"cases" => $rows, 
				"addnew"=> $info)); // also give the option to add a new client
}
?>
