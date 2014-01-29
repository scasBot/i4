<?php
if(!isset($UserID)) 
	trigger_error("Need to set a UserID"); 

// Clients assisted
$results = query("SELECT COUNT(*) AS res FROM (SELECT DISTINCT ClientID FROM db_Contact "
	. "WHERE ContactTypeID IN (10,12,16,20,24,30,90,91,93,99) AND UserID=$UserID "
	. "UNION SELECT DISTINCT ClientID FROM dbi4_Contacts " 
	. "WHERE ContactTypeID IN (10,12,16,20,24,30,90,91,93,99) AND UserAddedID=$UserID) AS tmp"); 
$stats["clients_assisted"] = $results[0]["res"]; 

// Clients assisted by phone
$results = query("SELECT COUNT(*) AS res FROM (SELECT DISTINCT ClientID FROM db_Contact "
	. "WHERE ContactTypeID IN (12,20,24,90,91,93) AND UserID=$UserID "
	. "UNION SELECT DISTINCT ClientID FROM dbi4_Contacts "
	. "WHERE ContactTypeID IN (12,20,24,90,91,93) AND UserAddedID=$UserID) AS tmp");
$stats["clients_assisted_by_phone"] = $results[0]["res"]; 

// Clients assisted by voicemail
$results = query("SELECT COUNT(*) AS res FROM (SELECT DISTINCT ClientID FROM db_Contact WHERE ContactTypeID = 10 AND UserID=$UserID "
	. "UNION SELECT DISTINCT ClientID FROM dbi4_Contacts WHERE ContactTypeID = 10 AND UserAddedID=$UserID) AS tmp");
$stats["clients_assisted_by_voicemail"] = $results[0]["res"];  

// Clients assisted by e-mail
$results = query("SELECT COUNT(*) AS res FROM (SELECT DISTINCT ClientID FROM db_Contact WHERE ContactTypeID = 16 AND UserID=$UserID "
	. "UNION SELECT DISTINCT ClientID FROM dbi4_Contacts WHERE ContactTypeID = 16 AND UserAddedID=$UserID) AS tmp");
$stats["clients_assisted_by_email"] = $results[0]["res"];

// Clients assisted by appointment
$results = query("SELECT COUNT(*) AS res FROM (SELECT DISTINCT ClientID FROM db_Contact WHERE ContactTypeID = 30 AND UserID=$UserID " 
	. "UNION SELECT DISTINCT ClientID FROM dbi4_Contacts WHERE ContactTypeID = 30 AND UserAddedID=$UserID) AS tmp");
$stats["clients_assisted_by_appointment"] = $results[0]["res"]; 

$data = $stats; 
?>