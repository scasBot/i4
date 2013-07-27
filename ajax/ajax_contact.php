<?php
	require("../includes/client_class.php"); 
	
	if(!isset($data["Action"], $data["Contact"])) {
		echo "Error: Inomplete items in data"; 
		die(); 
	}
	
	if($Contact["ContactID"] == 0) {
	
		if(!isset($ID)) {
			echo "Error: Incomplete items in data"; 
			die(); 
		}
	
		$Contact["UserAddedID"] = $data["ID"]; 
		$data["Contact"]["UserEditID"] = $data["ID"]; 
	
		$contact = new Contact(); 
		assert2($contact->from_array($data["Contact"]), "Didn't work from array");  
		assert2($contact->push(), "Failure to update mysql");  
		$contact_type = get_contacttype($contact->get("ContactTypeID")); 
	
		echo json_encode(array("Success" => true, 
			"data" => array("ContactID" => $contact->get("ContactID"), "ContactType" => $contact_type))); 
		
		die(); 

	} else if ($data["Action"] == "Delete") {
		$contact = new Contact($data["Contact"]["ContactID"]); 
		$contact->delete(); 
	
		echo json_encode(array("Success" => true)); 
		die(); 
	
	} else if ($data["Action"] == "Update") {
		if(!isset($data["ID"])) {
			echo "Error: Incomplete items in data"; 
			die(); 
		}	
	
		$contact = new Contact($data["Contact"]["ContactID"]);
		$data["Contact"]["UserEditID"] = $data["ID"]; 
		$contact->from_array($data["Contact"]); 
		$contact->push(); 

		echo json_encode(array("Type" => "Old", "Success" => true, 
			"data" => array("ContactType" => get_contacttype($data["Contact"]["ContactTypeID"]))));
		die(); 
	
	} else {
		echo json_encode(array("Success" => false));
		die(); 
	}
?>
