<?php
/*******************************
newcient.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : 
	Adds a new client to the database, 
	$_POST variables must be extremely robust and match
	all the entries of the class ClientInfo
***********************************/
require("../includes/config.php"); 
require("../includes/client_class.php"); 

// accessing by GET is incorrect, sorry
if($_SERVER["REQUEST_METHOD"] == "GET") {
	apologize("Can't access this page by GET request."); 
}

// accessing by POST is correct
else if($_SERVER["REQUEST_METHOD"] == "POST") {

	// create the new client info entry in the database
	$info = new ClientInfo(); 
	assert2($info->from_array($_POST), "POST items are incorrect." );
	assert2($info->set("State", "MA"));  // default state is MA
	assert2($info->set("Language", "English")); // default language is English
	assert2($info->push(), "Failed to insert into server in newclient.php"); 
	$client_id = $info->get("ClientID"); 
	
	// priority is a different object than ClientInfo
	$priority = new Priority(); 
	$priority->from_array(array("ClientID" => $client_id, "CaseTypeID" => 21)); // by default 21 is never been contacted
	$priority->push(); 
	
	// redirects to the client's contact page
	redirect("client.php?ClientID=" . $client_id); 
}
	
?>