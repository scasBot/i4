<?php
if (!defined("LIMITING_NUMBERXX")) {
	define("LIMITING_NUMBERXX", 100); 
}
if (!isset($id)) {
	trigger_error("Need to set priority ID"); 
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
        . "SELECT dbi4_Contacts.* FROM dbi4_Contacts "
            . "INNER JOIN ((SELECT MAX(ContactID) AS ContactID "
            . "FROM dbi4_Contacts GROUP BY ClientID) AS MaxContacts) "
        . "ON dbi4_Contacts.ContactID = MaxContacts.ContactID "
    . ") Contacts "
	. "ON Clients.ClientID = Contacts.ClientID "
	. "ORDER BY ContactDate DESC "
	. "LIMIT " . LIMITING_NUMBERXX;

$data = query($query, $id);
?>
