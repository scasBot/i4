<?php

/**
 * Executes SQL statement, possibly with parameters, returning
 * an array of all rows in result set or false on (non-fatal) error.
 */
function query(/* $sql [, ... ] */) {
	// SQL statement
	$sql = func_get_arg(0);

	// parameters, if any
	$parameters = array_slice(func_get_args(), 1);

	// try to connect to database
	static $handle;
	if (!isset($handle))
	{
		try
		{
			// connect to database
			$handle = new PDO("mysql:dbname=" . QUERY_DATABASE . ";host=" . QUERY_SERVER, QUERY_USERNAME, QUERY_PASSWORD);

			// ensure that PDO::prepare returns false when passed invalid SQL
			$handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
		}
		catch (Exception $e)
		{
			// trigger (big, orange) error
			trigger_error($e->getMessage(), E_USER_ERROR);
			exit;
		}
	}

	// prepare SQL statement
	$statement = $handle->prepare($sql);
	if ($statement === false)
	{
		$tmp = array(); 
		$tmp = $handle->errorInfo(); 
		
		// trigger (big, orange) error
		trigger_error($tmp[2], E_USER_ERROR);
		exit;
	}

	// execute SQL statement
	$results = $statement->execute($parameters);

	// return result set's rows, if any
	if ($results !== false)
	{
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	else
	{
		return "FAIL";
	}
}

/****
* Return query string from q_arr with items : "TABLE", "WHERE"
*
*********/
function query_delete($q_arr) {
	$query = "DELETE FROM `" . $q_arr["TABLE"] . "` "; 
	
	if(!isset($q_arr["WHERE"])) {
		return Null; 
	}
	
	$where_maker = create_function("\$k,\$v", 
		"return \"`\" . \$k . \"`\" . \$v[0] . \"'\" . \$v[1] . \"'\";"); 
			
	$query .= "WHERE " . arr_to_str($where_maker, "AND ", " ", $q_arr["WHERE"]);	
	
	return $query; 
}

/**
* Return query string from q_arr with items : "TABLE", "INSERT",
*
*
******/
function query_insert($q_arr) {
	// INSERT clause
	$query = "INSERT INTO `" . $q_arr["TABLE"] . "` SET "; 
	
	$elements = count($q_arr["INSERT"]); 
	
	if($elements < 1) {
		return NULL; 
	}	

	$insert_maker = create_function("\$k,\$v", " 
		return \"`\" . \$k . \"`='\" . \$v .\"'\";"); 
			
	$query .= arr_to_str($insert_maker, ", ", " ", $q_arr["INSERT"]);

	return $query; 
}

/** 
* Return query string from q_arr with items : "TABLE,", "UPDATE", "WHERE"
*
* e.g. $q_arr = ["TABLE" => "db_Clients", "UPDATE" => ["FirstName" => "Tom", "LastName" => "Bobbert"], 
*					"WHERE" => ["ClientID" => ["=", 1000]]]
****/
function query_update($q_arr) {
		// UPDATE clause
		$query = "UPDATE " . $q_arr["TABLE"] . " "; 
		
		if(isset($q_arr["UPDATE"]))
		{
			$update_maker = create_function("\$k,\$v", "
				return \"`\" . \$k . \"`='\" . \$v . \"'\";"); 

			$query .= "SET " . arr_to_str($update_maker, ", ", " ", $q_arr["UPDATE"]); 
		}
		else
		{
			return false; 
		}
		
		if(isset($q_arr["WHERE"]))
		{
			$where_maker = create_function("\$k,\$v", " 
				return \"`\" . \$k . \"`\" . \$v[0] . \"'\" . \$v[1] . \"'\";"); 
			
			$query .= "WHERE " . arr_to_str($where_maker, "AND ", " ", $q_arr["WHERE"]); 
		}			
		else
		{
			return false; 
		}
		
		return $query; 
	}

/** 
* Return query string from q_arr with items : "TABLE," "TO_SELECT," "WHERE," AND "ORDER"
*
* e.g. $q_arr = ["TABLE" => "db_Clients", "TO_SE$LECT" => ["ClientID", "FirstName", "LastName"], 
*					"WHERE" => ["FirstName" => ["=", "Willy"]], ["ClientID" => [">", "1000"]]], "ORDER" => ["LastName" => "ASC", "FirstName" => "DESC"]
****/
function query_select($q_arr) {		
		// SELECT clause
		$query = "SELECT "; 

		if (isset($q_arr["TO_SELECT"])) {
			$select_maker = create_function("\$k,\$v", 
			"return \"`\" . \$v . \"`\";");  

			$query .= arr_to_str($select_maker, ", ", " ", $q_arr["TO_SELECT"]); 
		}
		else {
			$query .= "* "; 
		}
		
		// FROM clause
		$query .= "FROM " . $q_arr["TABLE"] . " "; 
		
		// WHERE clause
		if (isset($q_arr["WHERE"])) {
			$where_maker = create_function("\$k,\$v", 
				"return \"`\" . \$k . \"`\" . \$v[0] . \"'\" . \$v[1] . \"'\";"); 
			
			$query .= "WHERE " . arr_to_str($where_maker, "AND ", " ", $q_arr["WHERE"]); 
		}
		
		// ORDER BY clause
		if (isset($q_arr["ORDER"])) {
			$order_maker = create_function("\$k, \$v", 
				"return \"`\" . \$k . \"` \" . \$v; "); 

			$query .= "ORDER BY " . arr_to_str($order_maker, ", ", " ", $q_arr["ORDER"]); 
		}
		
		return $query; 
	}
?>