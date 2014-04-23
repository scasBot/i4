<?php
/*******************************
client_class.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description: Implements the iDataObjects
	for different client information in the 
	database. These include ClientInfo, 
	Contacts, and Old i3 Contacts.
***********************************/
// client info
class ClientInfo extends aDataObject implements iDataObject {
	protected $database_name = "db_Clients"; 
	protected $elements = array(
		"ClientID", "FirstName", "LastName", "Phone1Number", 
		"Phone2Number", "Email", "Address", "City", "State", 
		"Zip", "Language", "ClientNotes", "CaseTypeID", "CategoryID"); 
	protected $primary_key = "ClientID"; 
	
	// return the priority description of the client
	public function get_priority() {
		return unique_lookup("db_CaseTypes", $this->get("CaseTypeID"), 
			"CaseTypeID", "Description"); 
	}
	
	// return the category description of the client
	public function get_category() {
		return unique_lookup("db_Categories", $this->get("CategoryID"),
			"CategoryID", "Description"); 
	}
	
	// wrapper function because it has to check the phone numbers
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

		$to_copy = array("ClientID", "FirstName", "LastName", "Email", "City", "State", "Language", "CaseTypeID", "CategoryID"); 

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
		$to_update["CategoryID"] = $current["CategoryID"]; 
		
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

// dbi4_Contacts
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

	// converts a dbi4_contact into a converted contact array
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

// wrapper class for the entire client, should use sparingly, there are bugs
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

// old i4 contacts included here, should be read-only
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
		} else {
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
?>
