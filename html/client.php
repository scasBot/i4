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
							"UserName" => "Willy Xiao", 
							"ContactDate" => "05-11-13, 15:00",  
							"ContactEditDate" =>"05-11-13, 15:00", 
							"ContactType" => "Called, helped by phone", 
							"ContactSummary" => "This is a big deal that willy is in our database" . 
												"OMG he should like totes be in our database \n" . 
												"nomsayin' nomsayin'?"), 
						array(
							"ContactID" => 40,
							"UserName" => "Willy Xiao", 
							"ContactDate" => "03-11-13, 15:00", 
							"ContactEditDate" => "05-11-13, 15:03", 
							"ContactType" => "Added Client", 
							"ContactSummary" => "This is a big deal that willy is in our database" . 
												"OMG he should like totes be in our database \n" . 
												"nomsayin' nomsayin'?")							
					); 
		
		render("client_form.php", array("title" => "Client", "client" => $client, "contacts" => $contacts)); 
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// edit a client; 
	}
?>