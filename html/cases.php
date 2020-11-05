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
define("LIMITING_NUMBER_FOR_ONE_MESSAGE_LEFT", 20); 

// check usage
if($_SERVER["REQUEST_METHOD"] !== "GET" || !isset($_GET["type"])) {
	apologize("Must be a GET request."); 
}

switch ($_GET["type"]) {
	// list of cases by priority
	case "priority": 
		
		// gets all information from clients with CaseTypeID = $id
		function get_by_priority_id($id) {
			return model("cases_by_priority_id.php", array("id" => $id)); 			
		}

		// connect
	$dbh = new PDO("mysql:dbname=" . QUERY_DATABASE . ";host=" . QUERY_SERVER, QUERY_USERNAME, QUERY_PASSWORD);
	// $dbh = new PDO('mysql:host=localhost;dbname=masmallc_scas', 'masmallc_scas', "LWn-tmX-ETv-N7M");
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	// prepare and execute
	$phone_tag = $dbh->prepare('SELECT db_Clients.*, db_CaseTypes.Description AS Priority FROM db_Clients, db_CaseTypes WHERE db_Clients.CaseTypeID = 11 AND db_CaseTypes.CaseTypeID = 11 AND db_Clients.LastEditTime > "2018-03-01"');
	$phone_tag->execute();
	$phone_tag = $phone_tag->fetchAll(\PDO::FETCH_ASSOC);

	$urgent_language = $dbh->prepare('SELECT db_Clients.*, db_CaseTypes.Description AS Priority FROM db_Clients, db_CaseTypes WHERE db_Clients.CaseTypeID = 100 AND db_CaseTypes.CaseTypeID = 100 AND db_Clients.LastEditTime > "2018-03-01"');
	$urgent_language->execute();
	$urgent_language = $urgent_language->fetchAll(\PDO::FETCH_ASSOC);

	$urgent_time = $dbh->prepare('SELECT db_Clients.*, db_CaseTypes.Description AS Priority FROM db_Clients, db_CaseTypes WHERE db_Clients.CaseTypeID = 101 AND db_CaseTypes.CaseTypeID = 101 AND db_Clients.LastEditTime > "2018-03-01"');
	$urgent_time->execute();
	$urgent_time = $urgent_time->fetchAll(\PDO::FETCH_ASSOC);	

	$urgent_court = $dbh->prepare('SELECT db_Clients.*, db_CaseTypes.Description AS Priority FROM db_Clients, db_CaseTypes WHERE db_Clients.CaseTypeID = 102 AND db_CaseTypes.CaseTypeID = 102 AND db_Clients.LastEditTime > "2018-03-01"');
	$urgent_court->execute();
	$urgent_court = $urgent_court->fetchAll(\PDO::FETCH_ASSOC);	

	$no_contacted = $dbh->prepare('SELECT db_Clients.*, db_CaseTypes.Description AS Priority FROM db_Clients, db_CaseTypes WHERE db_Clients.CaseTypeID = 21 AND db_CaseTypes.CaseTypeID = 21 AND db_Clients.LastEditTime > "2018-03-01"');
	$no_contacted->execute();
	$no_contacted = $no_contacted->fetchAll(\PDO::FETCH_ASSOC);	

	$one_message_left = $dbh->prepare('SELECT db_Clients.*, db_CaseTypes.Description AS Priority FROM db_Clients, db_CaseTypes WHERE db_Clients.CaseTypeID = 22 AND db_CaseTypes.CaseTypeID = 22 AND db_Clients.LastEditTime > "2018-03-01"');
	$one_message_left->execute();
	$one_message_left = $one_message_left->fetchAll(\PDO::FETCH_ASSOC); 

	$undefined = $dbh->prepare('SELECT db_Clients.*, db_CaseTypes.Description AS Priority FROM db_Clients, db_CaseTypes WHERE db_Clients.CaseTypeID = 0 AND db_CaseTypes.CaseTypeID = 0 AND db_Clients.LastEditTime > "2018-03-01"');
	$undefined->execute();
	$undefined = $undefined->fetchAll(\PDO::FETCH_ASSOC); 

	$upcoming_appt = $dbh->prepare('SELECT db_Clients.*, db_CaseTypes.Description AS Priority FROM db_Clients, db_CaseTypes WHERE db_Clients.CaseTypeID = 10 AND db_CaseTypes.CaseTypeID = 10 AND db_Clients.LastEditTime > "2019-06-01"');
	$upcoming_appt->execute();
	$upcoming_appt = $upcoming_appt->fetchAll(\PDO::FETCH_ASSOC);	

	$legal_research = $dbh->prepare('SELECT db_Clients.*, db_CaseTypes.Description AS Priority FROM db_Clients, db_CaseTypes WHERE db_Clients.CaseTypeID = 52 AND db_CaseTypes.CaseTypeID = 52 AND db_Clients.LastEditTime > "2019-06-01"');
	$legal_research->execute();
	$legal_research = $legal_research->fetchAll(\PDO::FETCH_ASSOC);	

		if ((count($urgent_language) + count($urgent_time)+ count($urgent_court) + count($no_contacted) + count($undefined) + count($phone_tag)) < LIMITING_NUMBER_FOR_ONE_MESSAGE_LEFT) {
			$one_message_left = get_by_priority_id(22);
			$cases = array_merge($undefined, $urgent_language, $urgent_court, $urgent_time, $upcoming_appt, $no_contacted, $phone_tag, $one_message_left, $legal_research);
		} else {
			$cases = array_merge($undefined, $urgent_language, $urgent_court, $urgent_time, $upcoming_appt, $no_contacted, $phone_tag, $legal_research);
		}

		render("cases_list.php", array("title" => "By " . $_GET["type"], 
			"cases" => $cases, 
			"addnew" => null)); // addnew shouldn't be shown, can change template to use isset to avoid this.

		break; 

	// date orders the cases by the last contact date added in dbi4_contacts
	case "date":

		// get the clients with most recent 100 contacts added
		$clients = 
			"(SELECT db_Clients.ClientID, FirstName, LastName, Phone1AreaCode, "
				. "Phone1Number, Email, CaseTypeID, Language, ContactDate "
			. "FROM db_Clients "
			. "INNER JOIN (dbi4_Contacts AS contacts) " 
			. "ON contacts.ClientID=db_Clients.ClientID "
			. "ORDER BY contacts.ContactDate DESC LIMIT " . LIMITING_NUMBER . ") "
			. "clients"; 

		// NOTE: This code is unreliable for some reason...
		//		it sometimes returns the wrong ContactTypeID. 
		// 		Should be investigated

		// get their priority information too
		$cases = query(
			"SELECT clients_pre.*, Contacts.ContactTypeID FROM " 
			. "(SELECT DISTINCT clients.ClientID, FirstName, LastName, "
			. "Phone1AreaCode, Phone1Number, Email, clients.CaseTypeID, Language, Priority "
			. "FROM $clients "
			. "INNER JOIN (SELECT CaseTypeID, `Description` AS Priority "
				. "FROM db_CaseTypes "
				. "WHERE Deprecated=0) priority "
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
