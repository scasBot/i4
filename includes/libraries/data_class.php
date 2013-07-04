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
	protected $id; 

	// name of primary key (where id comes from)
	protected $primary_key; 
	protected $database_name; 
	
	// an array of the element names of this object
	protected $elements = array();

	// booleans that tell if current local data is synced and
	// if the object already exists in the database
	protected $exists = false; 
	protected $synced; 
	
	// local copy of all values
	protected $local = array(); 
	
	public function __construct($id = null) {
		foreach($this->elements as $element) {
			$this->local["$element"] = null; 
		}
	
		if(isset($id)) {
			if(!$this->set_by_id($id)) {
				throw new Exception("Failure to set dataobject by id : " . $id); 
			}
		}
	}
	
	// this can be overwritten in inheritances
	private function construct_start($id) {return true;} 
	private function construct_end($id) {return true;} 
	
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
	abstract protected function delete_specific(); 
	
	// inserting a new element returns an id
	abstract protected function push_insert_specific();
	
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
			}
			else {
				return ($this->synced = true); 
			}
		}
		else {
			$id = $this->push_insert_specific(); 
			
			if(!$id) {
				return false; 
			}
			else {
				return ($this->set_by_id($id)); 
			}; 			
		} 
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
		return true;  
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

abstract class aPureDataObject extends aDataObject implements iDataObject {
	protected function pull_specific() {
		$queried = query(query_select(array(
			"TABLE" => $this->database_name, 
			"WHERE" => array($this->primary_key => 
				array("=", $this->id))
		))); 
		
		if(!$queried) {
			return false; 
		}
		else {
			$q = $queried[0]; 
			return($this->from_array($q)); 
		}
	}
	
	protected function push_update_specific() {
		query(query_update(array(
			"TABLE" => $this->database_name,
			"WHERE" => array($this->primary_key => 
				array("=", $this->id)), 
			"UPDATE" => $this->get_array()
		))); 
		
		return true; 
	}
	
	protected function delete_specific() {
		query(query_delete(array(
			"TABLE" => $this->database_name, 
			"WHERE" => array($this->primary_key => 
				array("=", $this->id))
		))); 
		
		return true; 
	} 
	
	// inserting a new element returns an id
	protected function push_insert_specific() {
		query(query_insert(array(
			"TABLE" => $this->database_name, 
			"INSERT" => $this->get_array()
		))); 

		$rows = query(query_select(array(
			"TABLE" => $this->database_name, 
			"SELECT" => array($this->primary_key),
			"ORDER" => array($this->primary_key => "DESC"), 
			"LIMIT" => 3))
		); 
			
		if(!$rows) {
			return null; 
		}
		else {
			foreach($rows as $row) {
				$bool = true; 
				
				foreach($this->elements as $element) {
					$bool = $bool && ($row[$element] == $this->get($element)); 
				}

				if($bool) {
					return $row[$this->primary_key]; 
				}
			}
			
			return null; 
		}
	}	
}
?>