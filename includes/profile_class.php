<?php

class Profile extends aPureDataObject implements iDataObject {
	protected $matchers = array("UserName", "Email", "YOG"); 
	protected $elements = array("UserID", "UserName", "Email", "YOG", "Comper", "Hidden"); 
	protected $primary_key = "UserID"; 
	protected $database_name = "i3_Users"; 
}

class Password extends aPureDataObject implements iDataObject {
	protected $matchers = array("UserID", "hash"); 
	protected $elements = array("UserID", "hash"); 
	protected $primary_key = "UserID"; 
	protected $database_name = "i3_Passwords"; 
}
?>
