<?php
if(!isset($limit))
	$limit = 100; 

if(!isset($UserID)) 
	trigger_error("No UserID set"); 

// get the last clients touched by user
$clients = 
	"(SELECT clients_pre.*, Contacts.ContactTypeID FROM " 
	. "(SELECT DISTINCT db_Clients.ClientID, FirstName, LastName, "
		. "Phone1AreaCode, Phone1Number, Email, CaseTypeID "  
	. "FROM dbi4_Contacts "
	. "INNER JOIN db_Clients "
	. "ON db_Clients.ClientID=dbi4_Contacts.ClientID "
	. "WHERE UserAddedID=? OR UserEditID=? "
	. "LIMIT " . $limit . ")  clients_pre "
	. "INNER JOIN ("
			. "SELECT dbi4_Contacts.ClientID, ContactTypeID, ContactDate FROM dbi4_Contacts "
			. "INNER JOIN ("
				. "SELECT MAX(ContactID) AS ContactID FROM dbi4_Contacts "
				. "GROUP BY ClientID) max_contact "
			. "ON dbi4_Contacts.ContactID = max_contact.ContactID"
		. ") Contacts "
	. "ON clients_pre.ClientID = Contacts.ClientID "
	. "ORDER BY ContactDate DESC) clients "; 


// get their information
$cases = query(
	"SELECT clients.*, Description AS Priority "
	. "FROM $clients INNER JOIN db_CaseTypes " 
	. "ON clients.CaseTypeID=db_CaseTypes.CaseTypeID", 
		$UserID, $UserID); 	

$data = $cases; 
?>