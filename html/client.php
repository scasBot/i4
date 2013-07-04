<?php

	require("../includes/config.php"); 
	require("../includes/client_class.php"); 
	
	// is the correct request method used
	$correct_req_method = false; 
	$client_id = null; 
	
	// accessing by a GET request means display contact
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		
		// usage checking
		if(!isset($_GET["ClientID"])) {
			apologize("Missing ID item in GET request"); 
		}
	
		// if asking to delete, assert the correct code and delete the client
		if(isset($_GET["DELETE"])) { 
			$client = new Client(); 
			
			$client = new Client(); 
			assert2($client->initialize($_GET["ClientID"]));  
			assert2($client->delete());  
			redirect("index.php"); 
		}
		else {
			$correct_req_method = true;
			$client_id = $_GET["ClientID"];		
		}
	}

	// accessing by POST request means the client needs to be updated
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// usage checking
		if(!isset($_POST["ClientID"])) {
			apoologize("Missing ID item in POST request"); 
		}

		$correct_req_method = true; 

		// create new client info object and update it
		$client_info_obj = new ClientInfo($_POST["ClientID"]); 
		assert2($client_info_obj->from_array($_POST), "Updating client failed...fields in $_POST are incorrect"); 
		assert2($client_info_obj->push(), "Updating the database failed on client : " . $client_info_obj->get("ClientID"));
		$client_id = $client_info_obj->get("ClientID"); 
		unset($client_info_obj); 
	}
	
	// if the methods were correct
	if($correct_req_method) {
		
		// create a new client and initialize it
		$client = new Client(); 
		assert2($client->initialize($client_id), "Client object problem"); 
		
		// grab the client's necessary items
		$client_info = $client->info->get_array(); 		
		$contacts = $client->contacts; 
		$i3_contact = $client->old_contacts; 	
		
		if(isset($i3_contact["contacts"])) {
			// sort old contacts by date
			$compare = create_function("\$a,\$b", 
				"return \$b['ContactDate'] - \$a['ContactDate'];"); 
			usort($i3_contact["contacts"], $compare);
		}; 

		// grab the contact types
		$contact_types = get_contact_types();

		// remove variables
		unset($correct_req_method); 
		unset($client_id); 
		
		// display it!
		render("client_form.php", array("title" => "Client", "client" => $client_info, "contacts" => $contacts,
			"contact_types" => $contact_types, "i3_contact" => $i3_contact, "random_quote" => $filler->random_quote())); 		
	}
	else {
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