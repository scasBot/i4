<?php

class ClientInfo extends aDataObject implements iDataObject {
	protected $database_name = "db_Clients"; 
	protected $elements = array(
		"ClientID", "FirstName", "LastName", "Phone1Number", 
		"Phone2Number", "Email", "Address", "City", "State", 
		"Zip", "Language", "ClientNotes", "CaseTypeID"); 
	protected $primary_key = "ClientID"; 
	
	public function get_priority() {
		return unique_lookup("db_CaseTypes", $this->get("CaseTypeID"), 
			"CaseTypeID", "Description"); 
	}
	
	// needs to check values are legitimate
	public function set($element, $value) {
		
		// strips any other punctuation from phone numbers
		if($element == "Phone1Number" || $element == "Phone2Number") {
			$value = only_numbers($value); 
		}
	
		return parent::set($element, $value); 
	}

	// query the database, edit it and then update the client
	protected function pull_specific() {
		$client_queried = query(query_select(
			array(
				"TABLE" => $this->database_name, 
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

		$to_copy = array("ClientID", "FirstName", "LastName", "Email", "City", "State", "Language", "CaseTypeID"); 

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

	// query the database for a delete
	protected function delete_specific() {
		query(query_delete(array(
			"TABLE" => $this->database_name, 
			"WHERE" => array($this->primary_key => 
				array("=", $this->id))
		))); 
		
		return true; 
	}
	
	// array needed to update
	private function to_update_array() {
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
		$to_update["CaseTypeID"] = $current["CaseTypeID"]; 
		
		return $to_update; 
	}

	protected function push_update_specific() {
		$to_update = $this->to_update_array(); 
		
		if(!$to_update) {
			return false; 
		}
		else {
			query(query_update(array(
				"TABLE" => $this->database_name, 
				"UPDATE" => $to_update, 
				"WHERE" => array($this->primary_key => array("=", $this->id))
			))); 
		
			return true; 
		}
	} 
	
	protected function push_insert_specific() {
		$to_update = $this->to_update_array(); 
		
		if(!$to_update) {
			return false; 
		}
		else {
			query(query_insert(array(
				"TABLE" => $this->database_name, 
				"INSERT" => $to_update))
			); 

			$rows = query(query_select(array(
				"TABLE" => $this->database_name, 
				"SELECT" => array($this->primary_key),
				"ORDER" => array("ClientID" => "DESC"), 
				"LIMIT" => 3))
			); 
			
			if(!$rows) {
				return null; 
			} else {
				foreach($rows as $row) {
					if($row["FirstName"] == $this->get("FirstName")
						&& $row["Email"] == $this->get("Email")
						&& $row["LastName"] == $this->get("LastName")
						&& $row["Address1"] == $this->get("Address")) {
						return $row[$this->primary_key]; 
					}
				}
				
				return null; 
			}
		}
	} 
}

class Contact extends aPureDataObject implements iDataObject {
	protected $matchers = array(
		"ContactTypeID", 
		"ContactDate", "UserAddedID", 
		"UserEditID", "ClientID"); 

	protected $elements = array(
		"ContactID", "ContactTypeID", 
		"ContactDate", "ContactEditDate", 
		"UserAddedID", "UserEditID", 
		"ContactSummary", "ClientID"); 
	protected $database_name = "dbi4_Contacts";
	protected $primary_key = "ContactID";
	
	public function get_converted_array() {
		if($this->exists) {
			$to_copy = array("ClientID", "ContactID", "ContactDate", 
				"ContactEditDate", "ContactSummary", "ContactTypeID"); 
			$contacts = array(); 
			$pure_array = $this->get_array(); 
			
			foreach($pure_array as $field => $value) { 
				if(in_array($field, $to_copy)) {
					$contacts[$field] = $value; 
				}
			}

			$contacts["UserName"]["Edit"] = get_username($pure_array["UserEditID"]); 
			$contacts["UserName"]["Added"] = get_username($pure_array["UserAddedID"]);
			$contacts["Email"]["Edit"] = get_useremail($pure_array["UserEditID"]); 
			$contacts["Email"]["Added"] = get_useremail($pure_array["UserAddedID"]); 
			$contacts["ContactType"] = get_contacttype($pure_array["ContactTypeID"]);
			
			return $contacts; 
		}
		else {
			return null; 
		}
	}
}

/*
class Priority extends aPureDataObject implements iDataObject {
	protected $matchers = array(
		"ClientID", "CaseTypeID"); 

	protected $elements = array(
		"ClientID", "CaseTypeID"); 	
	protected $database_name = "dbi4_Priority"; 
	protected $primary_key = "ClientID"; 
	
	// get the description of the priority
	public function get_description() {
		return unique_lookup("db_CaseTypes", 
			$this->get("CaseTypeID"), "CaseTypeID", "Description"); 
	}
	
	// sets the CaseTypeID depending on the ContactTypeID
	public function set_from_contactid($contactTypeID) {
		switch ($contactTypeID) {
			case 1 : 
			case 2 : 
			case 21 : 
			case 15 : 
				$this->set("CaseTypeID", 21); 
				break; 
		}
	}
}
*/

class Client extends aDataObject implements iDataObject {
	protected $elements = array(
		"contacts", "info",/* "priority", */"old_contacts"); 

	protected $primary_key = "ClientID"; 
	protected $database_name = null; 
	
	protected function pull_specific() {
		return (/*$this->pull_priority() && */
				$this->pull_info() && 
				$this->pull_old_contacts() && 
				$this->pull_contacts());  
	}
	
	protected function push_update_specific() {
		// need to implement
		return false; 
	}
	protected function delete_specific() {
		$success = true; 
	
		try {
			$success = $success && $this->pull(); 
		
			$success = $success && $this->get("info")->delete() && 
				$this->get("old_contacts")->delete() /* && $this->get("priority")->delete()*/; 

			foreach($this->get("contacts") as $contact) {
				$success = $success && $contact->delete(); 
			}
			
			return $success; 
		} catch (Exception $e) {
			throw new Exception("delete_specific failure: " . $e->getMessage()); 
		}
	}
	protected function push_insert_specific() {
		// need to implement
		return 0; 
	}
	
	public function auto_set_priority() {
		// need to implement
		return false; 
	}

/*	
	public function pull_priority() {
		try {
			return $this->set("priority", new Priority($this->id)); 
		}
		catch (Exception $e) {
			$priority = new Priority(); 
			$priority->set("ClientID", $this->id);

			// 0 for undefined
			$priority->set("CaseTypeID", 0); 
			return $priority->push(); 
		}
	}
*/	
	public function pull_info() {
		return $this->set("info", new ClientInfo($this->id)); 
	}
	
	public function pull_old_contacts() {
		return $this->set("old_contacts", new OldContacts($this->id)); 
	}
	
	public function pull_contacts() {
		$this->contacts = array(); 
		$rows = query(query_select(array(
			"TABLE" => "dbi4_Contacts", 
			"WHERE" => array("ClientID" => 
				array("=", $this->id))
		))); 
		
		$tmp = array(); 		
		foreach ($rows as $row) {
			$tmp[] = new Contact($row["ContactID"]); 
		}
		
		return $this->set("contacts", $tmp); 
	}
	
	public function get_contacts_array() {
		if($this->exists) {
			$contacts = array(); 
			foreach($this->get("contacts") as $contact) {
				$contacts[] = $contact->get_converted_array(); 
			}
			
			return $contacts; 
		}
		else {
			return null; 
		}
	}
}

class OldContacts {
	private $id;  
	private $exists; 
	private $contacts = array();
	private $notes; 
	
	function __construct($id = null) {
		if(!is_null($id)) {
			$this->id = $id; 
			$this->pull(); 
		}
	}
	
	public function get_contacts() {
		if($this->exists) {
			return $this->contacts;
		}
		else {
			return null; 
		}
	}
	
	public function get_notes() {
		if($this->exists) {
			return $this->notes; 
		}
		else {
			return null; 
		}
	}
	
	public function get_exists() {
		return $this->exists; 
	}
		
	public function pull() {
		$queried = query(query_select(array(
			"TABLE" => "db_CaseInfo", 
			"WHERE" => array("ClientID" => array("=", $this->id)
		)))); 
	
		if(!$queried) {
			return ($this->exists = false); 
		}
		else {
			$this->exists = true; 
		}
		
		$notes = ""; 
		foreach($queried as $row) {
			$notes .= $row["Notes"] . "\n"; 
		}

		$this->notes = $notes; 
		
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
		
		$this->contacts = $old_contacts; 
		return true; 			
	}
	
	/* We don't actually have to delete any of the old contacts from the database
		we don't care about it that much and it doesn't really take up too much space, 
		plus we want to keep the old i3 working */
	public function delete() {
		return true; 
	}
}

/*
class Client{
	private $exists = false;
	public $info; 
	public $contacts = array();
	public $old_contacts = array();
	public $id; 

	function __construct($id = null) {
		if(!is_null($id)) {			
			$this->info = new ClientInfo($id);
		}	
		else {
			$this->info = new ClientInfo(); 
		}
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
		$this->info->set_by_id($client_id); 
		
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
			return $this->info->pull();
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
*/
?>
