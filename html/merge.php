<?php

// configuration
require("../includes/config.php"); 
require("../includes/client_class.php"); 

// anything more than LIMIT_NUMBER should be assumed to be an error
define("LIMIT_NUMBER", 40); 

if(COMPER) {
	apologize("Sorry, compers can't access this option."); 
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
	if(!isset($_GET["Client1"])) {
		apologize("Sorry, need at least 1 client to merge."); 
	}
	
	render("merge_form.php", array("title" => "Merge", "ClientID" => $_GET["Client1"])); 
	//apologize("Sorry, this page hasn't been implemented yet");
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// type-check the inputs
	if(!isset($_POST["ClientID1"], $_POST["ClientID2"]) 
		|| is_null($_POST["ClientID1"]) 
		|| is_null($_POST["ClientID2"]) 
		|| !is_numeric($_POST["ClientID1"])
		|| !is_numeric($_POST["ClientID2"])
		|| $_POST["ClientID1"] <= 0
		|| $_POST["ClientID2"] <= 0) {
		apologize("Failed type-checking."); 
	}

	// update client info
	$client1 = new ClientInfo($_POST["ClientID1"]); 
	assert2($client1->from_array($_POST)); 
	assert2($client1->push()); 
	
	// update the required items in each database
	$tables = array("db_CaseInfo", "db_Contact", "dbi4_Contacts"); 
	foreach($tables as $table) {
		try {
			query("UPDATE " . $table . " SET ClientID=" . $_POST["ClientID1"] 
				. " WHERE ClientID=" . $_POST["ClientID2"] . " LIMIT " . LIMIT_NUMBER); 
		} catch (Exception $e) {
			apologize("Something broke: " . $e); 
		}
	}
	
	// delete client2
	$client2 = new ClientInfo($_POST["ClientID2"]); 
	assert2($client2->delete());
	
	// go to merged client
	redirect("client.php?ClientID=" . $client1->get_id()); 
}
?>
