<?php
if (!defined("LIMITING_NUMBERXX")) {
	define("LIMITING_NUMBERXX", 100); 
}

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
	. "ORDER BY ContactDate DESC "
	. "LIMIT " . LIMITING_NUMBERXX;

$data = query($query, $id);
?>