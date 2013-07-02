<?php

class ClientInfo {
	private $exists = false; 
	private $elements = array(
		"ClientID", "FirstName", "LastName", "Phone1Number", 
		"Phone2Number", "Email", "Address", "City", "State", 
		"Zip", "Language", "ClientNotes"); 
		
	public $ClientID; 
	public $FirstName; 
	public $LastName; 
	public $Phone1Number; 
	public $Phone2Number; 
	public $Email; 
	public $Address; 
	public $City; 
	public $State; 
	public $Zip; 
	public $Language; 
	public $ClientNotes;
	
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
		$this->ClientID = $client_id;
		
		return $this->exists; 
	}
	
	public function refresh() {
		if($this->exists) {
			$client_queried = query(query_select(
				array(
					"TABLE" => "db_Clients", 
					"WHERE" => 
						array("ClientID" => 
							array(
								"=", 
								$this->ClientID
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
			
			return $this->from_array($client);
		}
		else {
			return false; 
		}
	}

	public function from_array($arr) {		
		foreach($arr as $key => $value) {
			if(in_array($key, $this->elements)) {
				$this->$key = $value; 
			}
		}
		$this->exists = true; 
		return true; 
	}
	
	public function get_array() {
		if($this->exists) {
			$return = array(); 
			
			foreach($this->elements as $val) {
				$return[$val] = $this->$val; 
			}

			return $return; 
		}
		else {
			return Null; 
		}
	} 
	
	public function get_elements() {
		return $this->elements; 
	}
	
	public function update_database() {
		if($this->exists) {
			$dif = array("Phone1Number", "Phone2Number", "Zip", "Address", "ClientNotes");
			$to_update = array();
			$current = $this->get_array(); 
			
			foreach($this->elements as $val) {
				if(!in_array($val, $dif)) {
					$to_update[$val] = $current[$val]; 
				}
			}
			
			$to_update["Phone1AreaCode"] = substr($current["Phone1Number"], 0, 3); 
			$to_update["Phone1Number"] = substr($current["Phone1Number"], 3, 3) . "-" . substr($current["Phone1Number"], 6); 
			$to_update["Phone2AreaCode"] = substr($current["Phone2Number"], 0, 3); 
			$to_update["Phone2Number"] = substr($current["Phone2Number"], 3, 3) . "-" . substr($current["Phone2Number"], 6); 
			$to_update["ZIP"] = $current["Zip"]; 
			$to_update["Address1"] = $current["Address"]; 
			$to_update["Notes"] = $current["ClientNotes"]; 
			
			query(query_update(array(
				"TABLE" => "db_Clients", 
				"UPDATE" => $to_update, 
				"WHERE" => array("ClientID" => array("=", $to_update["ClientID"]))
			))); 
			
			return true; 
		}
		else {
			return false; 
		}
	}
}

class Client{
	private $exists = false;
	public $info; 
	public $contacts = array(); 
	public $old_contacts = array();
	public $id; 

	function __construct() {
		$this->info = new ClientInfo(); 
	}
	
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
		$this->info->set_client($client_id); 
		
		return $this->exists; 
	}
	
	public function refresh_all() { 		
		if($this->exists) {
			return 
				$this->refresh_info() &&  
				$this->refresh_contacts() &&
				$this->refresh_old_contacts(); 			
		}
		else {
			return false; 
		}
	}
	
	public function refresh_info() {
		if($this->exists) {
			return $this->info->refresh();
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
				$contacts[$key]["ContactTypeID"] = $value["ContactTypeID"]; 
				$contacts[$key]["ClientID"] = $this->id; 
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
