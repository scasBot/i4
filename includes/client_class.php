<?php

interface iDataObject {
	// revealing to the world
	public function get_id(); 
	public function get_elements(); 
	public function get_synced(); 
	public function get_exists(); 
	public function get_database_name();
	
	// initializing the object
	public function set_by_id($id); 
	
	// database actions
	public function pull(); 
	public function push(); 
	public function delete(); 
	
	// getting and setting local elements
	public function get($element); 
	public function set($element, $value);
	
	// setting all items based on the arrays
	public function from_array($arr); 
	public function get_array(); 
}

abstract class aDataObject implements iDataObject {
	// id of object in database
	private $id; 
	// name of primary key (where id comes from)
	private $primary_key; 

	private $database_name; 

	// booleans that tell if current local data is synced and
	// if the object already exists in the database
	private $exists = false; 
	private $synced; 
	
	// an array of the element names of this object
	private $elements = array(); 
	// local copy of all values
	private $local = array(); 

	public function __constructor($id = null) {
		if(isset($id)) {
			if(!$this->set_by_id($id)) {
				throw new Exception("Failure to set dataobject by id : " . $id); 
			}
		}
	}
	
	// helper functions to give items based on existence of object
	private function give_mutable($item) {
		if($this->exists) {
			return $this->$item; 
		}
		else {
			return null; 
		}
	}
	
	// giving elements back based on existence
	public function get_id() {
		return give_mutable("id"); 
	}
	public function get_synced() {
		return give_mutable("synced"); 
	}
	public function get_elements() {
		return $this->elements; 
	}
	public function get_exists() {
		return $this->exists; 
	}
	public function get_database_name() {
		return $this->database_name; 
	}
	
	// getter
	public function get($element) {
		if(in_array($element, $this->elements)) {
			return $this->local[$element]; 
		}
		else {
			return null; 
		}
	}	
	// setter
	public function set($element, $value) {
		if(in_array($element, $this->elements)) {
			$this->synced = false; 
			$this->local[$element] = $value; 
			return true; 
		}
		else {
			return false; 
		}
	}
	
	// set the object by its id
	public function set_by_id($id) {
		// these two must be set before a call to pull()
		$this->id = $id; 
		$this->exists = true; 
		
		if(!$this->pull()) {
			$this->exists = false;
			$this->id = null;
			$this->wipe_all(); 
			return false; 
		} 
		else {
			return true; 
		}
	}
	
	// clears all items
	private function wipe_all() {
		foreach($this->elements as $element) {
			$this->local[$element] = null; 
		}
	}

	// specific function for each class to update the items, must return a bool
	abstract protected function pull_specific(); 
	abstract protected function push_update_specific(); 
	abstract protected function push_insert_specific(); 
	abstract protected function delete_specific(); 
	
	// updates the object from the server
	public function pull() {
		if($this->exists) {
			$this->wipe_all(); 
				
			if(!$this->pull_specific()) {
				return false; 
			}			
			
			$this->synced = true; 
			return true; 
		}
		else {
			return false; 
		}
	}
	
	// push to server $this->local
	public function push() {
		if($this->exists) {
			if(!$this->push_update_specific()) {
				return false; 
			};  
		}
		else {
			if(!$this->push_insert_specific()) {
				return false; 
			}; 			
		}
		$this->synced = true; 
		return($this->exists = true); 
	}
	
	// deletes the object from the server
	public function delete() {
		if($this->exists) {
			$this->exists = false; 
			$this->wipe_all(); 
			$this->synced = null; 			
			return $this->delete_specific(); 
		}
		else {
			return false; 
		}
	}

	// updating self from array
	public function from_array($arr) {
		foreach($arr as $key => $val) {
			$this->set($key, $val); 
		}
		return($this->synced = false);  
	}
	
	// giving back array of elements
	public function get_array() {
		$return = array(); 
		foreach($this->elements as $val) {
			$return[$val] = $this->get($val); 
		}
		return $return; 
	}
}

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
		return($this->exists = true); 
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

	public function delete() {
		if($this->exists) {
			query(query_delete(array(
				"TABLE" => "db_Clients", 
				"WHERE" => array("ClientID" => 
					array("=", $this->ClientID))
			))); 
			
			$this->exists = false; 
			$this->ClientID = null; 
			return true; 
		}
		else {
			return false; 
		}
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

class Contact {
	private $exists = false; 
	private $elements = array(
		"ContactID", "ContactTypeID", 
		"ContactDate", "ContactEditDate", 
		"UserAddedID", "UserEditID", 
		"ContactSummary", "ClientID"); 
	
	public $ContactID;  
	public $ContactTypeID; 
	public $ContactDate; 
	public $ContactEditDate; 
	public $UserAddedID; 
	public $UserEditID; 
	public $ContactSummary; 
	public $ClientID; 
	
	public $displayed = array(); 
	
	public function set_contact($contact_id) {
		$response = query(query_select(
			array("TABLE" => "dbi4_Contacts", 
					"WHERE" => array("ContactID" => 
						array("=", $contact_id))))
		); 
		
		if(count($response) > 1) {
			apologize("Too many contacts match id : " . $contact_id); 
		}
		
		$this->exists = count($response) == 1; 
		$this->ContactID = $contact_id;
		
		return $this->exists; 
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
