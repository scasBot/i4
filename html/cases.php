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
require("../includes/config.php"); 
require("../includes/client_class.php"); 

define("LIMITING_NUMBER", 100); // limit the number of cases

// check usage
if($_SERVER["REQUEST_METHOD"] !== "GET") {
	apologize("Must be a GET request."); 
}

// list of cases by priority
if($_GET["type"] == "priority") {		

	// gets all information from clients with CaseTypeID = $id
	function get_by_priority_id($id) {
		return query(
			"SELECT * FROM db_Clients INNER JOIN ((SELECT CaseTypeID, `Description` AS Priority FROM "
			. "db_CaseTypes WHERE Deprecated=0) AS t1) ON t1.CaseTypeID=db_Clients.CaseTypeID WHERE " 
			. "db_Clients.CaseTypeID=" . $id); 
	}
	
	// these can be changed easily to reflect different ordering of priorities
	$urgent = get_by_priority_id(1); 
	$no_contacted = get_by_priority_id(21); 
	$undefined = get_by_priority_id(0); 
	$phone_tag = get_by_priority_id(11); 
	
	// this might be a source of the slowness
	$cases = array_merge($undefined, $urgent, $no_contacted, $phone_tag);
	
// date orders the cases by the last contact date added in dbi4_contacts
} else if ($_GET["type"] == "date") {

	// get the clients with most recent 100 contacts added
	$clients = "((SELECT db_Clients.ClientID, FirstName, LastName, Phone1AreaCode, Phone1Number, Email, " 
		. "CaseTypeID, ContactDate FROM db_Clients INNER JOIN (dbi4_Contacts AS contacts) " 
		. "ON contacts.ClientID=db_Clients.ClientID ORDER BY " 
		. "contacts.ContactDate DESC LIMIT " . LIMITING_NUMBER . ") AS clients)"; 

	// get their priority information too
	$cases = query("SELECT DISTINCT clients.ClientID, FirstName, LastName, Phone1AreaCode, Phone1Number, Email, "
		. "Priority FROM $clients INNER JOIN ((SELECT CaseTypeID, `Description` AS Priority FROM " 
		. "db_CaseTypes WHERE Deprecated=0) AS priority) ON clients.CaseTypeID=priority.CaseTypeID ORDER BY clients.ContactDate DESC"); 

} else if ($_GET["type"] == "me") {

	// get the last clients touched by user
	$clients = "((SELECT DISTINCT db_Clients.ClientID, FirstName, LastName, Phone1AreaCode, Phone1Number, Email, CaseTypeID "  
		. "FROM dbi4_Contacts INNER JOIN db_Clients ON db_Clients.ClientID=dbi4_Contacts.ClientID WHERE UserAddedID=" . $_SESSION["id"] . " " 
		. "OR UserEditID=" . $_SESSION["id"] . " ORDER BY ContactDate DESC "
		. "LIMIT " . LIMITING_NUMBER . ") AS clients)"; 
	
	// get their information
	$cases = query("SELECT clients.*, Description AS Priority FROM $clients INNER JOIN db_CaseTypes " 
		. "ON clients.CaseTypeID=db_CaseTypes.CaseTypeID"); 	
	
} else {
	apologize("Can't access cases like that."); 
}

render("cases_list.php", array("title" => "By " . $_GET["type"], 
	"cases" => $cases, 
	"addnew" => null)); // addnew shouldn't be shown, can change template to use isset to avoid this.
?>
