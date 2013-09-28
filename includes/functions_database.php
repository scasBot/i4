<?php
/*******************************
functions_database.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013
***********************************/

/**
* Returns values as a function of keys from the database
*
**/
function unique_lookup($table, $key, $key_field, $val_field) {
	try {
		$results = query(query_select(array(
			"TABLE" => $table, 
			"WHERE" => array($key_field => 
				array("=", $key)))
		));
	} catch (Exception $e) {
		throw new Exception("Unique lookup failed, backtrace: " . $e->getMessage()); // if there's an error, something must not have been found
	}

	/* no longer enforcing one return*/
	if(empty($results)) {
		return null; 
	}
	
	$result = $results[0]; 
	return $result[$val_field]; 		
}

function get_useremail($user_id) {
	return unique_lookup("i3_Users", $user_id, "UserID", "Email");  
}

function get_username($user_id) {
	global $filler; 
	$result = unique_lookup("i3_Users", $user_id, "UserID", "UserName"); 
	if (is_null($result)) {
		return $filler->random_celeb(); 
	}
	else {
		return $result; 
	}
}
function get_contacttype($contacttype_id) {
	$result = unique_lookup("db_ContactTypes", $contacttype_id, "ContactTypeID", "Description"); 
	assert2(count($result) == 1, $contacttype_id . " did not match 1 result."); 
	return $result; 
}
	
// returns all the contact types as an array with ID => Description
function get_contact_types() {
	$contact_type_rows = query(query_select(
		array(
			"TABLE" => "db_ContactTypes", 
			"WHERE" => 
				array("Visible" => 
					array(
						"=", 
						1
					)
				), 
			"ORDER" => 
				array("Description" => "ASC"
				)		
		)			
	)); 
	$contact_types = array(); 		
	foreach($contact_type_rows as $row) {
			$contact_types[$row['ContactTypeID']] = $row['Description']; 
	}
	
	return $contact_types; 
}

// returns all the priorities 
function get_priorities() {
	static $rows; 
	
	if(!isset($rows)) {
		$rows = query(query_select(
			array(
				"TABLE" => "db_CaseTypes", 
				"WHERE" => array("Deprecated" => array("=", 0)),
				"ORDER" => array("Description" => "ASC"))
		)); 	
	}
	
	$priorities = array(); 
	foreach($rows as $row) {
		$priorities[$row["CaseTypeID"]] = $row["Description"]; 
	}
	
	return $priorities; 
}

// finds if user is a comper
function is_comper($id) {
	$comper = unique_lookup("i3_Users", $id, "UserID", "Comper"); 
	return($comper == 1); 
}

function is_admin($id) {
	try {
		$result = query(query_select(array(
			"TABLE" => "i3_Admins", 
			"WHERE" => array(
				"UserID" => array("=", $id))
		))); 		
		return (count($result) > 0); 
	} catch (Exception $e) {
		return false; 
	}
}

class i3_log extends aPureDataObject implements iDataObject {
	protected $matchers = array("UserID", "Login", "IP"); 
	protected $elements = array("LogID", "UserID", "Login", "Logout", "IP"); 
	protected $database_name = "i3_Log"; 
	protected $primary_key = "LogID"; 
}

function mysql_date() {
	return date("Y-m-d H:i:s"); 
}

function set_i3_log() {
	$log = new i3_Log(); 
	$log->set("UserID", $_SESSION["id"]); 
	$log->set("Login", mysql_date());
	$log->set("IP", $_SERVER['REMOTE_ADDR']); 
	$log->push(); 
	return $log->get("LogID"); 
}
?>