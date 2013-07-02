<?php
	if($data["Contact"]["ContactID"] == 0) {
		$contact = $data["Contact"]; 

		$insert = query_insert(array(
			"TABLE" => "dbi4_Contacts", 
			"INSERT" => 
				array(
					"ClientID" => $contact["ClientID"], 
					"UserAddedID" => $data["ID"], 
					"UserEditID" => $data["ID"], 
					"ContactDate" => $contact["ContactDate"], 
					"ContactEditDate" => $contact["ContactEditDate"], 
					"ContactTypeID" => $contact["ContactTypeID"], 
					"ContactSummary" => $contact["ContactSummary"]
		)));
				
		query($insert); 
		
		$rows = query(query_select(array(
			"TABLE" => "dbi4_Contacts", 
			"TO_SELECT" => array("ContactID"), 
			"WHERE" => array(
				"ContactEditDate" => array("=", $contact["ContactEditDate"]), 
				"ContactDate" => array("=", $contact["ContactDate"]), 
				"UserAddedID" => array("=", $data["ID"])
		)))); 
		
		$row = $rows[0]; 
		$contact_type = get_contacttype($contact["ContactTypeID"]); 			
	
		echo json_encode(array("Type" => "New", "Success" => true, 
			"data" => array("ContactID" => $row["ContactID"], "ContactType" => $contact_type))); 
		
		die(); 
	}
	else if ($data["Action"] == "Delete") {
		query(query_delete(array(
			"TABLE" => "dbi4_Contacts", 
			"WHERE" => 
				array("ContactID" => array("=", $data["Contact"]["ContactID"]))
		))); 
	
		echo json_encode(array("Success" => true)); 
		die(); 
	}
	else if ($data["Action"] == "Update") {
		$keys = array("ContactDate", "ContactTypeID", "ContactSummary", "ContactEditDate", "ContactDate"); 

		$arr_func = create_function("\$k, \$v", 
			"global \$data; 
			return array(\$v => \$data[\"Contact\"][\$v]);"); 						
		$update_array = map_kv($arr_func, $keys); 

		query(query_update(
			array("TABLE" => "dbi4_Contacts", 
				"WHERE" => 
					array("ContactID" => array("=", $data["Contact"]["ContactID"])), 
				"UPDATE" => $update_array
			)
		));

		echo json_encode(array("Type" => "Old", "Success" => true, 
			"data" => array("ContactType" => get_contacttype($data["Contact"]["ContactTypeID"]))));
		die(); 
	}
	else {
		echo json_encode(array("Success" => false));
		die(); 
	}
?>
