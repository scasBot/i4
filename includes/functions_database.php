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
	/* this throws a warning for some reason:
	    Warning: count(): Parameter must be an array or an object that implements Countable in /home4/masmallc/public_html/i4/includes/functions_database.php on line 57
	    */
    assert2(!is_null($result), $contacttype_id . " did not match 1 result."); 
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

// returns all categories
function get_categories() {
	static $rows; 
	if(!isset($rows)) {
		$rows = query("SELECT * FROM db_Categories ORDER BY SortKey ASC"); 
	}
	
	$categories = array(); 
	foreach($rows as $row) {
		$categories[$row["CategoryID"]] = $row["Description"]; 
	}
	
	return $categories; 
}

function get_referral_sources() {
	static $rows; 
	
	if(!isset($rows)) {
		$rows = query("SELECT * FROM db_ReferralSources ORDER BY SortKey ASC"); 
	}
	
	$referral_sources = array(); 
	foreach($rows as $row) {
		$referral_sources[$row["ReferralSourceID"]] = $row["Description"]; 
	}
	
	return $referral_sources; 
}

// returns a random word with $len
	// http://codepad.org/9Y8CpnDx
function get_randomword($len = 10) {
    $word = array_merge(range('a', 'z'), range('A', 'Z'));
    shuffle($word);
    return substr(implode($word), 0, $len);
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

class i3_log {
	private $LogID; 

	public function __construct($LogID = null) {
		if(is_null($LogID)) {
			query("INSERT INTO i3_Log (UserID, Login, IP) VALUES (?, NOW(), ?)", 
				$_SESSION["id"], $_SERVER["REMOTE_ADDR"]); 
			$log = query("SELECT LogID FROM i3_Log WHERE UserID=? AND IP=? ORDER BY LogID DESC LIMIT 1", 
				$_SESSION["id"], $_SERVER["REMOTE_ADDR"]); 
			$this->LogID = $log[0]["LogID"]; 
		} else {
			$this->LogID = $LogID; 
		}
	}

	public function update() {
		try {
			$log = query("SELECT TIMESTAMPDIFF(SECOND, LastAction, CURRENT_TIMESTAMP) as Seconds FROM i3_Log WHERE LogID=?", 
				$this->LogID); 
		
			if($log[0]["Seconds"] > IDLE_TIME_LIMIT) {
				redirect("logout.php"); 
			}
		} catch (Exception $e) {
			throw new Exception("Error, log failed: " . $e->getMessage()); 
		}

		query("UPDATE i3_Log SET LastAction=CURRENT_TIMESTAMP WHERE LogID=?", $this->LogID); 
		return; 	
	}

	public function logout() {
		query("UPDATE i3_Log SET LastAction=LastAction, Logout=CURRENT_TIMESTAMP WHERE LogID=?", 
			$this->LogID); 	
	}
		
	public function get_LogID() {
		return $this->LogID; 
	}
	
}

function mysql_date() {
	return date("Y-m-d H:i:s"); 
}

function set_i3_log() {
	$log = new i3_Log(); 
	return $log->get_LogID(); 
}

// updates the i3_log with most recent activity, if it's been passed IDLE_TIME_LIMIT, then it will auto
// log-out the user. 
function update_i3_log() {
	$log = new i3_Log($_SESSION["logid"]); 
	$log->update(); 
	return; 
}

?>