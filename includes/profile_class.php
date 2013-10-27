<?php

class Profile extends aPureDataObject implements iDataObject {
	protected $matchers = array("UserName", "Email", "YOG"); 
	protected $elements = array("UserID", "UserName", "Email", "YOG", "Comper", "Hidden"); 
	protected $primary_key = "UserID"; 
	protected $database_name = "i3_Users";

	public function set($field, $val) {
		if($field === "Email" 
			&& !filter_var($val, FILTER_VALIDATE_EMAIL)) {
			throw new Exception("Email address invalid."); 
			return false; 
		} else {
			return parent::set($field, $val); 
		}
	}
}

class Password extends aPureDataObject implements iDataObject {
	protected $matchers = array("UserID", "hash"); 
	protected $elements = array("UserID", "hash"); 
	protected $primary_key = "UserID"; 
	protected $database_name = "i3_Passwords"; 
}
?>
