<?php
/*******************************
ajax_contact.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : Updates and inserts
	contacts into the database. 
***********************************/

// using contact class
require("../includes/client_class.php"); 

// check data fields
if(!isset($data["Action"], $data["Contact"])) {
	echo "Error: Inomplete items in data"; 
	die(); 
}

// 0 means it's a new contact
if($data["Contact"]["ContactID"] == 0) {

	// check client ID
	if(!isset($data["ID"])) {
		echo "Error: Incomplete items in data"; 
		die(); 
	}

	// update some fields of array
	$data["Contact"]["UserAddedID"] = $data["ID"]; 
	$data["Contact"]["UserEditID"] = $data["ID"]; 

	// push contact to server and return
	$contact = new Contact(); 
	assert2($contact->from_array($data["Contact"]), "Didn't work from array");  
	assert2($contact->push(), "Failure to update mysql");  
	$contact_type = get_contacttype($contact->get("ContactTypeID")); 

	// if assigning email then do other stuff
	if (isset($data["emailId"]))
	{
		$clientID = $data["Contact"]["ClientID"];
		$emailId = $data["emailId"];

		// first, set isAssigned and clientId
		$query = "UPDATE db_Emails SET isAssigned=1, ClientID=$clientID WHERE id=$emailId";
		query($query);

		// second, update case type to "never been contacted"
		$query = "UPDATE db_Clients SET ContactTypeID=21 WHERE ClientID=$clientID";
		query($query);

	}

	echo json_encode(array("Success" => true, 
		"data" => array("ContactID" => $contact->get("ContactID"), "ContactType" => $contact_type))); 
	
	die(); 

// deleting the contact
} else if ($data["Action"] == "Delete") {
	$contact = new Contact($data["Contact"]["ContactID"]); 
	$contact->delete(); 

	echo json_encode(array("Success" => true)); 
	die(); 

// updating the contact
} else if ($data["Action"] == "Update") {
	if(!isset($data["ID"])) {
		echo "Error: Incomplete items in data"; 
		die(); 
	}	

	// update the contact
	$contact = new Contact($data["Contact"]["ContactID"]);
	$data["Contact"]["UserEditID"] = $data["ID"]; 
	assert2($contact->from_array($data["Contact"])); 
	assert2($contact->push()); 

	echo json_encode(array("Type" => "Old", "Success" => true, 
		"data" => array("ContactType" => get_contacttype($data["Contact"]["ContactTypeID"]))));
	die(); 

// action was incorrect
} else {
	echo json_encode(array("Success" => false));
	die(); 
}
?>
