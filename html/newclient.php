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
	assert2($info->from_array($_POST), "POST items are incorrect.");

	// set default values
	assert2($info->set("State", "MA"));
	assert2($info->set("Language", "English"));
	assert2($info->set("ClientID", 0));
	assert2($info->set("CategoryID", 0));
	assert2($info->set("CourtDate", NULL));
	assert2($info->set("CaseTypeID", 21));
	assert2($info->set("ReferralSpecify", ""));

	assert2($info->push(), "Failed to insert into server in newclient.php");
	$client_id = $info->get("ClientID");

	// if there's an emailId, add it as a new contact
	if (isset($_POST["emailId"]))
	{
		redirect("assignEmail.php?ClientID=" . $client_id . "&id=" . $_POST["emailId"]);
	}
	else
	{
		// redirects to the client's contact page
		redirect("client.php?ClientID=" . $client_id);
	}
}

?>
