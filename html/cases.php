<?php
/*******************************
cases.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : One of the menu options. 
Returns the cases_list template with information. 
***********************************/

/***********************************NEED BETTER ALGORITHM, THIS IS SLOW *********************/

require("../includes/config.php"); 
require("../includes/client_class.php"); 

if($_SERVER["REQUEST_METHOD"] == "GET")
{	
	// priority from table dbi4_Priority
	if($_GET["type"] == "priority") {		

		function get_by_priority_id($id) {
			return query(query_select(array(
			"TABLE" => "db_Clients", 
			"WHERE" => array("CaseTypeID" => array("=", $id))
			))); 
		}
		
		// these can be changed easily to reflect different ordering of priorities
		$urgent = get_by_priority_id(1); 
		$no_contacted = get_by_priority_id(21); 
		$undefined = get_by_priority_id(0); 
		$phone_tag = get_by_priority_id(11); 
		
		// this might be a source of the slowness
		$rows = array_merge($undefined, $urgent, $no_contacted, $phone_tag);
		
	// date orders the cases by the last contact date added in dbi4_contacts
	} else if ($_GET["type"] == "date") {

		$rows = query(query_select(array(
			"TABLE" => "dbi4_Contacts",
			"SELECT" => array("ClientID"), 
			"ORDER" => array("ContactDate" => "DESC"), 
			"LIMIT" => 100 // currently only selecting 100
		))); 


		/* We only want to display each client once, this means we have to check
			if the client has already been shown */
		$taken = array();
		foreach($rows as $key => $row) {
			if(!isset($taken[$row["ClientID"]])) {
				$client_info = new ClientInfo($row["ClientID"]); 
				$rows[$key]["CaseTypeID"] = $client_info->get("CaseTypeID"); 
				$taken[$row["ClientID"]] = "";
			} else {
				unset($rows[$key]); 
			}
		}
	} else {
		apologize("Can't access cases like that."); 
	}

	$priorities = get_priorities(); // holds all of the priorites from db_CaseTypes
	
	/* Grabs all the elements that should be shown for each client */
	$to_show = array(); // will hold all the clients that should be shown
	foreach($rows as $row) {
		$queried = query(query_select(array(
			"TABLE" => "db_Clients", 
			"SELECT" => array("FirstName", "LastName", "Phone1AreaCode", "Phone1Number", "Email", "CaseTypeID"), 
			"WHERE" => array("ClientID" => array("=", $row["ClientID"]))
		))); 
		$queried[0]["Priority"] = $priorities[$row["CaseTypeID"]]; // get the priority 
		$to_show[] = $queried[0];	
	}
	
	render("cases_list.php", 
		array("title" => "By Priority", 
			"cases" => $to_show, 
			"addnew" => null)); // addnew shouldn't be shown, can change template to use isset to avoid this.
} else {
	apologize("You can't submit here :( Sorry"); 
}

?>
