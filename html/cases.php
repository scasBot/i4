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

// limit the number of cases
define("LIMITING_NUMBER", 100);

// check usage
if($_SERVER["REQUEST_METHOD"] !== "GET" || !isset($_GET["type"])) {
	apologize("Must be a GET request."); 
}

switch ($_GET["type"]) {
	// list of cases by priority
	case "priority": 

		// gets all information from clients with CaseTypeID = $id
		function get_by_priority_id($id) {
			$query =
				"(SELECT db_Clients.*, Priority "
				. "FROM db_Clients "
				. "INNER JOIN ((SELECT CaseTypeID, `Description` AS Priority "
					. "FROM db_CaseTypes "
					. "WHERE Deprecated=0) AS t1) "
				. "ON t1.CaseTypeID=db_Clients.CaseTypeID "
				. "WHERE db_Clients.CaseTypeID=?) Clients"; 

			$query = 
				"SELECT *, ContactTypeID FROM $query "
				. "INNER JOIN ( "
					. "SELECT MAX(ContactID), ClientID, ContactTypeID, ContactDate FROM dbi4_Contacts "
					. "GROUP BY ClientID "
				. ") Contacts "
				. "ON Clients.ClientID = Contacts.ClientID "
				. "ORDER BY ContactDate DESC";
	
			return query($query, $id);
		}
		
		// these can be changed easily to reflect different ordering of priorities
		$urgent = get_by_priority_id(1); 
		$no_contacted = get_by_priority_id(21); 
		$undefined = get_by_priority_id(0); 
		$phone_tag = get_by_priority_id(11); 
	
		// this might be a source of the slowness
		$cases = array_merge($undefined, $urgent, $no_contacted, $phone_tag);

		render("cases_list.php", array("title" => "By " . $_GET["type"], 
			"cases" => $cases, 
			"addnew" => null)); // addnew shouldn't be shown, can change template to use isset to avoid this.

		break; 

	// date orders the cases by the last contact date added in dbi4_contacts
	case "date":

		// get the clients with most recent 100 contacts added
		$clients = 
			"((SELECT db_Clients.ClientID, FirstName, LastName, Phone1AreaCode, "
				. "Phone1Number, Email, CaseTypeID, ContactDate "
			. "FROM db_Clients "
			. "INNER JOIN (dbi4_Contacts AS contacts) " 
			. "ON contacts.ClientID=db_Clients.ClientID "
			. "ORDER BY contacts.ContactDate DESC LIMIT " . LIMITING_NUMBER . ") "
			. "AS clients)"; 

		// NOTE: This code is unreliable for some reason...
		//		it sometimes returns the wrong ContactTypeID. 
		// 		Should be investigated

		// get their priority information too
		$cases = query(
			"SELECT clients_pre.*, Contacts.ContactTypeID FROM " 
			. "(SELECT DISTINCT clients.ClientID, FirstName, LastName, "
			. "Phone1AreaCode, Phone1Number, Email, clients.CaseTypeID, Priority "
			. "FROM $clients "
			. "INNER JOIN ((SELECT CaseTypeID, `Description` AS Priority "
				. "FROM db_CaseTypes "
				. "WHERE Deprecated=0) AS priority) "
			. "ON clients.CaseTypeID=priority.CaseTypeID) clients_pre " 
			. "INNER JOIN ("
					. "SELECT dbi4_Contacts.ClientID, ContactTypeID, ContactDate FROM dbi4_Contacts "
					. "INNER JOIN ("
						. "SELECT MAX(ContactID) AS ContactID FROM dbi4_Contacts "
						. "GROUP BY ClientID) max_contact "
					. "ON dbi4_Contacts.ContactID = max_contact.ContactID"
				. ") Contacts "
			. "ON clients_pre.ClientID = Contacts.ClientID "
			. "ORDER BY ContactDate DESC"); 

		render("cases_list.php", array("title" => "By " . $_GET["type"], 
			"cases" => $cases, 
			"addnew" => null)); // addnew shouldn't be shown, can change template to use isset to avoid this.

		break; 
	
	case "user" :
		if(!isset($_GET["UserID"])) {
			apologize("Must provide a UserId"); 
		}
		$UserID = $_GET["UserID"]; 
	case "me" : 
		if(!isset($UserID)) {
			$UserID = $_SESSION["id"]; 
		}
		
		$cases = model("cases_by_user.php", array("UserID" => $UserID)); 
		$stats = model("user_stats.php", array("UserID" => $UserID)); 
		
		render("profile_stats_form.php", array("title" => "Stats", 
			"cases" => $cases, 
			"stats" => $stats)); 
		break; 
			
	default: 
		apologize("Can't access cases like that."); 
}
?>
