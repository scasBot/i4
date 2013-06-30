<?php
	if($data["ContactID"] == 0) {
		echo json_encode(array("Type" => "New", "Success" => true)); 
	}
	else {
		$keys = array("ContactDate", "ContactTypeID", "ContactSummary", "UserEditID", "ContactEditDate", "ContactDate"); 

		$arr_func = create_function("\$k, \$v", 
			"global \$data; 
			return array(\$v => \$data[\$v]);"); 						
		$update_array = map_kv($arr_func, $keys); 
	
		/* query(query_update(
			array("TABLE" => "dbi4_Contacts", 
				"WHERE" => 
					array("ContactID" => array("=", $data["ContactID"])), 
				"UPDATE" => $update_array
			)
		)); */

		echo json_encode(array("Type" => "Old", "Success" => true)); 	
		
	}
?>
