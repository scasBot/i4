<?php

	require("../includes/config.php"); 
	
	// accessing by a GET request means display contact
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		
		// usage checking
		if(!isset($_GET["ClientID"])) {
			apologize("Missing items in GET request"); 
		}
	
		// get the client information
		$client = query(query_select(
			array(
				"TABLE" => "db_Clients", 
				"WHERE" => 
					array("ClientID" => 
						array(
							"=", 
							$_GET["ClientID"]
						)
					)
			)
		));

		// get contact information
		$contacts = query(query_select(
			array(
				"TABLE" => "db_Contact",
				"WHERE" => 
					array("ClientID" => 
						array(
							"=", 
							$_GET["ClientID"]
						)
					)
			)
		)); 

		// contact_types 
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
						"InUSA" => true, 
						"Language" => "English", 
						"ClientNotes" => "This client is a baus.", 
						"Category" => "Auto Law", 
						"CaseType" => "Assisted"); 
		
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
												"nomsayin' nomsayin'?")							
					); 
		
		// sort contacts by date
		$compare = create_function("\$a,\$b", 
			"return \$b['ContactDate'] - \$a['ContactDate'];"); 
		usort($contacts, $compare); 
		
		render("client_form.php", array("title" => "Client", "client" => $client, "contacts" => $contacts, "contact_types" => $contact_types)); 
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// edit a client; 
	}
?>