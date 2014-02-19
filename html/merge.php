<?php
/*******************************
merge.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description: Displays and handles the merge 
	client option from the geniusBar. 
***********************************/

// configuration
require("../includes/config.php"); 
require("../includes/client_class.php"); 

// maximum number of contacts that can be changed, 
// anything else assumed to be an error
define("LIMIT_NUMBER", 40); 

// compers not allowed to access
if(COMPER) {
	apologize("Sorry, compers can't access this option."); 
}

// requesting the merge page
if($_SERVER["REQUEST_METHOD"] == "GET") {

	// must input the client who's going to be base of merge
	if(!isset($_GET["Client1"])) {
		apologize("Sorry, need at least 1 client to merge."); 
	}
	
	render("merge_form.php", array("title" => "Merge", "ClientID" => $_GET["Client1"])); 

// posting the results of the merge
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// type-check the inputs
	if(!isset($_POST["ClientID1"], $_POST["ClientID2"]) 
		|| is_null($_POST["ClientID1"]) 
		|| is_null($_POST["ClientID2"]) 
		|| !is_numeric($_POST["ClientID1"]) // maybe use is_int?
		|| !is_numeric($_POST["ClientID2"])
		|| $_POST["ClientID1"] <= 0
		|| $_POST["ClientID2"] <= 0) {
		apologize("Failed type-checking."); 
	}

	// update client info
	$client1 = new ClientInfo($_POST["ClientID1"]); 
	assert2($client1->from_array($_POST)); 
	assert2($client1->push()); 
	
	// update the required items in each database
	$tables = array("db_CaseInfo", "db_Contact", "dbi4_Contacts"); 
	foreach($tables as $table) {
		try {
			query("UPDATE " . $table . " SET ClientID=? WHERE ClientID=? LIMIT " . LIMIT_NUMBER,
				$_POST["ClientID1"], 
				$_POST["ClientID2"]); 				
		} catch (Exception $e) {
			apologize("Something broke: " . $e); 
		}
	}
	
	// delete client2
	$client2 = new ClientInfo($_POST["ClientID2"]); 
	assert2($client2->delete());
	
	// display merged client
	redirect("client.php?ClientID=" . $client1->get_id()); 
}
?>
