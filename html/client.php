<?php

	require("../includes/config.php"); 
	require("../includes/client_class.php"); 
	
	// accessing by a GET request means display contact
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		
		// usage checking
		if(!isset($_GET["ClientID"])) {
			apologize("Missing items in GET request"); 
		}

		$client = new Client(); 
		assert2($client->initialize($_GET["ClientID"]), "Client object problem"); 
		$client_info = $client->info->get_array(); 
		$contacts = $client->contacts; 
		$i3_contact = $client->old_contacts; 		
		$contact_types = get_contact_types();
		
		// sort contacts by date
		$compare = create_function("\$a,\$b", 
			"return \$b['ContactDate'] - \$a['ContactDate'];"); 
		usort($i3_contact["contacts"], $compare);

		render("client_form.php", array("title" => "Client", "client" => $client_info, "contacts" => $contacts,
			"contact_types" => $contact_types, "i3_contact" => $i3_contact)); 
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$client_info = new ClientInfo(); 
		$client_info->from_array($_POST); 
		// $client_info->update_database(); 
		echo "done!"; 
	}
	
// returns all the contact types as an array with ID => Description
function get_contact_types() {
	$contact_type_rows = query(query_select(
		array(
			"TABLE" => "db_ContactTypes", 
			"WHERE" => 
				array("Visible" => 
					array(
						"=", 
						1
					)
				), 
			"ORDER" => 
				array("Description" => "ASC"
				)		
		)			
	)); 
	$contact_types = array(); 		
	foreach($contact_type_rows as $row) {
			$contact_types[$row['ContactTypeID']] = $row['Description']; 
	}
	
	return $contact_types; 
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