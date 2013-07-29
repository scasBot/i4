<?php
	require("../includes/client_class.php"); 
	
	try {
		// create new client info object and update it
		$client_info_obj = new ClientInfo($data["ClientID"]); 
		assert2($client_info_obj->from_array($data), "Updating client failed...fields in \$_POST are incorrect"); 
		assert2($client_info_obj->push(), "Updating the database failed on client : " . $client_info_obj->get("ClientID"));
		unset($client_info_obj); 
		
		// priority is currently not a part of ClientInfo so it needs a separate update
		$priority = new Priority($data["ClientID"]); 
		assert2($priority->set("CaseTypeID", $data["Priority"]), "Failed to set client priority"); 
		assert2($priority->push(), "Failed to push client priority");  
		unset($priority); 
	} catch(Exception $e) {
		echo json_encode(array("Success"=>false, "Message"=>$e->getMessage())); 
		die();
	}
	
	echo json_encode(array("Success"=>true)); 
	die(); 
?>
