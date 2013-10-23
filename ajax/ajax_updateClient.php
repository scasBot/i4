<?php
	require("../includes/client_class.php"); 
	
	try {
		// because priority is now in the CaseTypeID
		$data["Priority"] = $data["CaseTypeID"]; 
	
		// create new client info object and update it
		$client_info_obj = new ClientInfo($data["ClientID"]); 
		assert2($client_info_obj->from_array($data), "Updating client failed...fields in \$_POST are incorrect"); 
		assert2($client_info_obj->push(), "Updating the database failed on client : " . $client_info_obj->get("ClientID"));
				
	} catch(Exception $e) {
		echo json_encode(array("Success"=>false, "Message"=>$e->getMessage())); 
		die();
	}
	
	echo json_encode(array("Success"=>true)); 
	die(); 
?>
