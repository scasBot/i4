<?php

class Client{
	public $exists = false;
	public $info = array(); 
	public $contacts = array(); 
	public $old_contacts = array();
	public $id; 
	
	public function initialize($client_id) {
		return $this->set_client($client_id) && $this->refresh_all(); 
	}
	
	public function set_client($client_id) {
		$response = query(query_select(
			array("TABLE" => "db_Clients", 
					"WHERE" => array("ClientID" => 
						array("=", $client_id))))
		); 
		
		if(count($response) > 1) {
			apologize("Too many clients match id : " . $client_id); 
		}
		
		$this->exists = count($response) == 1; 
		$this->id = $client_id;
		
		return $this->exists; 
	}
	
	public function refresh_all() { 		
		if($this->exists) {
			return 
				$this->refresh_info() &&  
				$this->refresh_contacts() &&
				$this->refresh_old_contacts(); 			
		}
	}
	
	public function refresh_info() {
		if($this->exists) {
			$client_queried = query(query_select(
				array(
					"TABLE" => "db_Clients", 
					"WHERE" => 
						array("ClientID" => 
							array(
								"=", 
								$this->id
							)
						)
				)
			));
			$cq = $client_queried[0]; 

			$to_copy = array("ClientID", "FirstName", "LastName", "Email", "City", "State", "Language"); 

			$client = array(); 
			foreach($cq as $key => $value) {
				if(in_array($key, $to_copy)) {
					$client[$key] = $value; 
				}
			}
			$client["Phone1Number"] = only_numbers($cq["Phone1AreaCode"] . $cq["Phone1Number"]); 
			$client["Phone2Number"] = only_numbers($cq["Phone2AreaCode"] . $cq["Phone2Number"]); 
			$client["Address"] = $cq["Address1"]; 		
			$client["Zip"] = $cq["ZIP"]; 
			$client["ClientNotes"] = $cq["Notes"]; 
	
			$this->info = $client; 
			return true; 
		}
		else {
			return false; 
		}
	}
	
	public function refresh_contacts() {
		if($this->exists) {
			$queried = query(query_select(
				array("TABLE" => "dbi4_Contacts", 
						"WHERE" => array(
							"ClientID" => array("=", $this->id)))
			)); 

			$to_copy = array("ContactID", "ContactDate", "ContactEditDate", "ContactSummary"); 
			$contacts = array(); 
			
			foreach($queried as $key => $value) {
				$contacts[$key] = array(); 
				foreach($value as $field => $val) {
					if(in_array($field, $to_copy)) {
						$contacts[$key][$field] = $val; 
					}
				}
				
				$contacts[$key]["UserName"]["Edit"] = get_username($value["UserEditID"]); 
				$contacts[$key]["UserName"]["Added"] = get_username($value["UserAddedID"]); 
				$contacts[$key]["ContactType"] = get_contacttype($value["ContactTypeID"]); 
			}
			
			$this->contacts = $contacts; 
			return true; 
		}
		else {
			return false; 
		}
	}	

	public function refresh_old_contacts() {
		if($this->exists) {
			$queried = query(query_select(array(
				"TABLE" => "db_CaseInfo", 
				"WHERE" => array("ClientID" => array("=", $this->id)
			)))); 
		
			if(!$queried) {
				$this->old_contacts["exists"] = false; 
				return true; 
			}
			else {
				$this->old_contacts["exists"] = true; 
			}
			
			$notes = ""; 
			foreach($queried as $row) {
				$notes .= $row["Notes"] . "\n"; 
			}

			$this->old_contacts["notes"] = $notes; 
			
			$queried = query(query_select(array(
				"TABLE" => "db_Contact", 
				"WHERE" => array("ClientID" => array("=", $this->id)
			)))); 
			
			$old_contacts = array(); 
			foreach($queried as $num => $row) {
				$old_contacts[$num]["ContactDate"] = $row["Date"]; 
				$old_contacts[$num]["ContactType"] = get_contacttype($row["ContactTypeID"]); 
				$old_contacts[$num]["UserName"] = get_username($row["UserID"]); 
			}
			
			$this->old_contacts["contacts"] = $old_contacts; 
			return true; 			
		}
		else {
			return false; 
		}
	}
}

?>
