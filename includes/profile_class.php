<?php

class Profile extends aPureDataObject implements iDataObject {
	protected $matchers = array("UserName", "Email", "YOG"); 
	protected $elements = array("UserID", "UserName", "Email", "YOG"); 
	protected $primary_key = "UserID"; 
	protected $database_name = "i3_Users"; 
}


?>