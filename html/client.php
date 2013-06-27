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
		
		render("client_form.php", array("title" => "Client", "client" => $client[0], "contacts" => $contacts)); 
	}
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// edit a client; 
	}
?>