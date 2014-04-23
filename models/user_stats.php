<?php
/*
	$UserID - id of user whose stats you want
	$StartDate - the earliest you want to go back for stats
		* should be in MySql format
	$values - passed in from models - don't overwrite!
*/

require("z_i4_constants.php"); 
$contactTypeID = new ContactTypeID(); 
//if (!function_exists("clients_by")) {
	function clients_by($type, $arr) {
		extract($arr); 		
		return "SELECT COUNT(*) AS res FROM "
			. "(SELECT DISTINCT ClientID FROM db_Contact "
				. "WHERE ContactTypeID IN " . $type . " "
					. (isset($UserID) ? " AND UserID=$UserID " : "")
					. (isset($StartDate) ? " AND TIMEDIFF(Date, TIMESTAMP($StartDate))>0 " : "")
				. "UNION SELECT DISTINCT ClientID FROM dbi4_Contacts " 
				. "WHERE ContactTypeID IN " . $type
					. (isset($UserID) ? " AND UserAddedID=$UserID" : "")
					. (isset($StartDate) ? " AND TIMEDIFF(ContactDate, TIMESTAMP($StartDate))>0" : "")
					. ") "
			. "AS tmp"; 
	}
//}

// Clients assisted
$results = query(clients_by($contactTypeID->get_id_of("client_assisted", "MYSQL"), $values)); 
$stats["clients_assisted"] = $results[0]["res"]; 

// Clients assisted by phone
$results = query(clients_by($contactTypeID->get_id_of("client_assisted_by_phone", "MYSQL"), $values)); 
/*
$results = query(
	"SELECT COUNT(*) AS res FROM "
		. "(SELECT DISTINCT ClientID FROM db_Contact "
			. "WHERE ContactTypeID IN ". $contactTypeID->get_id_of("client_assisted_by_phone", "MYSQL") . " "
				. (isset($UserID) ? "AND UserID=$UserID " : "")
				. (isset($StartDate) ? "AND TIMEDIFF(Date, TIMESTAMP($StartDate))>0 " : "")
			. "UNION SELECT DISTINCT ClientID FROM dbi4_Contacts "
			. "WHERE ContactTypeID IN ". $contactTypeID->get_id_of("client_assisted_by_phone", "MYSQL") . " "
				. (isset($UserID) ? "AND UserAddedID=$UserID" : "")
				. (isset($StartDate) ? " AND TIMEDIFF(ContactDate, TIMESTAMP($StartDate))>0 " : "")
				. ") "
		. "AS tmp");
*/
$stats["clients_assisted_by_phone"] = $results[0]["res"]; 

// Clients assisted by voicemail
$results = query(clients_by("(" . $contactTypeID->get_id_of("Called, left message", "MYSQL") . ")", $values)); 
/*$results = query(
	"SELECT COUNT(*) AS res FROM "
		. "(SELECT DISTINCT ClientID FROM db_Contact "
			. "WHERE ContactTypeID = " . $contactTypeID->get_id_of("Called, left message") . " "
				. (isset($UserID) ? "AND UserID=$UserID " : "")
				. (isset($StartDate) ? "AND TIMEDIFF(Date, TIMESTAMP($StartDate))>0 " : "")
			. "UNION SELECT DISTINCT ClientID FROM dbi4_Contacts "
			. "WHERE ContactTypeID = " . $contactTypeID->get_id_of("Called, left message") . " "
				. (isset($UserID) ? "AND UserAddedID=$UserID" : "")
				. (isset($StartDate) ? " AND TIMEDIFF(ContactDate, TIMESTAMP($StartDate))>0 " : "")
				. ") "
		. "AS tmp");
*/
$stats["clients_assisted_by_voicemail"] = $results[0]["res"];  

// Clients assisted by e-mail
$results = query(clients_by("(" . $contactTypeID->get_id_of("Email, Response Sent", "MYSQL") . ")", $values)); 
/*$results = query(
	"SELECT COUNT(*) AS res FROM "
		. "(SELECT DISTINCT ClientID FROM db_Contact "
			. "WHERE ContactTypeID = " . $contactTypeID->get_id_of("Email, Response Sent") . " "
				. (isset($UserID) ? "AND UserID=$UserID " : "")
				. (isset($StartDate) ? "AND TIMEDIFF(Date, TIMESTAMP($StartDate))>0 " : "")
			. "UNION SELECT DISTINCT ClientID FROM dbi4_Contacts "
			. "WHERE ContactTypeID = " . $contactTypeID->get_id_of("Email, Response Sent") . " "
				. (isset($UserID) ? "AND UserAddedID=$UserID " : "")
				. (isset($StartDate) ? "AND TIMEDIFF(ContactDate, TIMESTAMP($StartDate))>0 " : "")
				. ") "
		. "AS tmp");
*/
$stats["clients_assisted_by_email"] = $results[0]["res"];

// Clients assisted by appointment
$results = query(clients_by("(" . $contactTypeID->get_id_of("Met with client", "MYSQL") . ")", $values)); 
/*$results = query(
	"SELECT COUNT(*) AS res FROM "
		. "(SELECT DISTINCT ClientID FROM db_Contact "
			. "WHERE ContactTypeID = " . $contactTypeID->get_id_of("Met with client") . " "
				. (isset($UserID) ? "AND UserID=$UserID " : "") 
				. (isset($StartDate) ? "AND TIMEDIFF(Date, TIMESTAMP($StartDate))>0 " : "")
			. "UNION SELECT DISTINCT ClientID FROM dbi4_Contacts "
			. "WHERE ContactTypeID = " . $contactTypeID->get_id_of("Met with client") . " "
				. (isset($UserID) ? "AND UserAddedID=$UserID " : "")
				. (isset($StartDate) ? "AND TIMEDIFF(ContactDate, TIMESTAMP($StartDate))>0 " : "")
				. ") "
		. "AS tmp");
*/
$stats["clients_assisted_by_appointment"] = $results[0]["res"]; 

// Clients assisted by month
$results = query(
	"SELECT COUNT(*) AS clients, month FROM "
		. "(SELECT DISTINCT ClientID, MONTH(Date) AS month FROM db_Contact "
				. "WHERE 1=1 "
				. (isset($UserID) ? "AND UserID=$UserID " : "")
				. (isset($StartDate) ? "AND TIMEDIFF(Date, TIMESTAMP($StartDate))>0 " : "")
			. "UNION SELECT DISTINCT ClientID, MONTH(ContactDate) AS month FROM dbi4_Contacts "
				. "WHERE 1=1"
				. (isset($UserID) ? " AND UserAddedID=$UserID" : "")
				. (isset($StartDate) ? " AND TIMEDIFF(ContactDate, TIMESTAMP($StartDate))>0" : "")
				. ") "
		. "AS tmp GROUP BY month");
$stats["clients_by_month"] = $results;

// Logins
$results = query(
	"SELECT Y, M, D, COUNT( * ) AS Logins, SUM( seconds ) AS seconds FROM "
		. "(SELECT YEAR( Login ) AS Y, MONTH( Login ) AS M, DAY( Login ) AS D, "
			. "TIME_TO_SEC( TIMEDIFF( LastAction, Login ) ) AS seconds FROM i3_Log "
			. "WHERE LastAction IS NOT NULL AND LastAction <>0 AND LastAction >= Login "
			. (isset($UserID) ? "AND UserID=$UserID " : "")
			. (isset($StartDate) ? "AND TIMEDIFF(Login, TIMESTAMP($StartDate)) > 0 " : "")
			. ") "
		. "AS tmp GROUP BY Y, M, D"); 
$stats["logins"] = $results;

$data = $stats; 
?>