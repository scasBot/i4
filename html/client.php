<?php
/*******************************
client.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description: Displays the client editing page. 
Calls template client_form which in turn also requires
contact_form and old_contact_form. This is probably
most complicated page on website. Lots of js necessary. 
***********************************/
require("../includes/config.php"); 
require("../includes/client_class.php"); 

$correct_req_method = false; // was the request method correct?
$client_id = null; //what's the client's id?

// accessing by a GET request means display contact
if($_SERVER["REQUEST_METHOD"] == "GET") {
	
	// usage checking
	if(!isset($_GET["ClientID"])) {
		apologize("Missing ID item in GET request"); 
	}

	// if asking to delete, assert the correct code and delete the client
	if(isset($_GET["DELETE"]) && !COMPER) { 
		try {
			$client = new Client($_GET["ClientID"]); 		

			if(!$client->delete()) {
				apologize("There was an error on the server in deleting the client, please " . 
					"contact " . ADMIN_EMAIL); 
			} else {
				redirect("cases.php?type=priority"); 
			}
		} catch (Exception $e) {
			apologize("There was an error on the server in deleting the client: " . 
				$e->getMessage() . " Please contact " . ADMIN_EMAIL); 
		}
	} else { // if not asking to delete and usage is correct, then show the variables
		$correct_req_method = true;
		$client_id = $_GET["ClientID"];		
	}
} 

// accessing by POST request means the client needs to be updated
else if($_SERVER["REQUEST_METHOD"] == "POST") {
	$_POST["Priority"] = $_POST["CaseTypeID"]; 

	// usage checking
	if(!isset($_POST["ClientID"])) {
		apoologize("Missing ID item in POST request"); 
	}

	$correct_req_method = true;

	// create new client info object and update it
	$client_info_obj = new ClientInfo($_POST["ClientID"]); 
	assert2($client_info_obj->from_array($_POST), "Updating client failed...fields in \$_POST are incorrect"); 
	assert2($client_info_obj->push(), "Updating the database failed on client : " . $client_info_obj->get("ClientID"));
	$client_id = $client_info_obj->get("ClientID"); 
	unset($client_info_obj); 
		
	redirect("client.php?ClientID=" . $_POST["ClientID"]); 
}

/* this code applies to both GET and POST requests
	but it should only run if the request_method was correct */
if($correct_req_method) {

	/* this one call grabs all the client information from the database
		the template requires specific variable names in specific formats right
		now... so....process a little bit to fit it. For all of these functions look at
		client_class.php */
	$client = new Client($client_id);
	$contacts = $client->get_contacts_array();
	$client_info = $client->get("info")->get_array();
	$priority = $client->get("info")->get_priority(); 
	$category = $client->get("info")->get_category(); 
	
	// check deprecated
	if (unique_lookup("db_CaseTypes", $priority, "Description", "Deprecated") == 1) {
		$priority = "Undefined"; 
	}
	
	if($i3_contacts["exists"] = $client->get("old_contacts")->get_exists()) {
		$i3_contacts["notes"] = $client->get("old_contacts")->get_notes(); 
		$i3_contacts["contacts"] = $client->get("old_contacts")->get_contacts(); 
		
		// sort old contacts by date
		$compare = create_function("\$a,\$b", 
			"return \$b['ContactDate'] - \$a['ContactDate'];"); 
		usort($i3_contacts["contacts"], $compare);
	}		 
	
	// remove variables
	unset($correct_req_method); 
	unset($client_id); 
	
	// display it!
	render("client_form.php", array("title" => "Client", "client" => $client_info, "contacts" => $contacts,
		"contact_types" => get_contact_types(), "i3_contacts" => $i3_contacts, "random_quote" => $filler->random_quote(), 
		"priorities" => get_priorities(), "priority" => $priority, "categories" => get_categories(), "category" => $category
	)); 		
}
else { // handler for incorrect request method
	apologize("Wrong request type for the page"); 
}
	
/*	Debugger example
$client = array("ClientID" => 32794, 
				"FirstName" => "Willy", 
				"LastName" => "Xiao", 
				"Phone1Number" => 6785514386, 
				"Phone2Number" => 6785840345,
				"Email" => "willy@chenxiao.us", 
				"Address" => "201 Southern Hill Dr", 
				"City" => "Johns Creek", 
				"State" => "GA", 
				"Zip" => 30097, 
				"Language" => "English", 
				"ClientNotes" => "This client is a baus.",

$contacts = array(
				array(
					"ContactID" => 57,
					"UserName" => array("Edit" => "Willy Xiao", "Added" => "Vignesh Shivishanmugam the Third"), 
					"ContactDate" => "2013-05-11 15:00:12",  
					"ContactEditDate" =>"2013-03-3 15:12:13", 
					"ContactType" => "Called, helped by phone", 
					"ContactSummary" => "This is a big deal that willy is in our database" . 
										"OMG he should like totes be in our database \n" . 
										"nomsayin' nomsayin'?"), 
				array(
					"ContactID" => 40,
					"UserName" => array("Edit" => "Willy Xiao", "Added" => "Bitch ass Bomb"), 
					"ContactDate" => "2013-06-12 15:00:22", 
					"ContactEditDate" => "2013-05-11 15:03:12", 
					"ContactType" => "Create client record", 
					"ContactSummary" => "AA This is a big deal that willy is in our database" . 
										"OMG he should like totes be in our database \n" . 
										"nomsayin' no\"\"\"\\\\msayin'?")							
			); 

			
$old_contact_notes = 
		"AA This is a big deal that willy is in our database" . 
		"OMG he should like totes be in our database \n" . 
		"nomsayin' no\"\"\"\\\\msayin'?";

$old_contacts = array(
					array(
						"ContactDate" => "2010-05-11 12:02:12", 
						"ContactType" => "Create client record",
						"UserName" => "Willy Xiao"
					), 
					array(
						"ContactDate" => "2010-03-12 12:02:12", 
						"ContactType" => "Called, helped by phone", 
						"UserName" => "Julianna Auccoin"
					), 
				); 
$i3_contact = array("exists" => true, "notes" => $old_contact_notes
	, "contacts" => $old_contacts);
	
*/
?>