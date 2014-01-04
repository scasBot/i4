<?php
/*******************************
ajax_searchUsers.php

By: Keon Chris Lim
klim01@college.harvard.edu

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

December 2013

Description: 
	Searches client with input from
	find_add_form.php
require("../includes/config.php"); 
require("../includes/client_class.php"); 
***********************************/


$result = searchClient($data);
$result["Success"] = true;
echo json_encode($result); 
die(); 


function insert_between_each_char($str, $between) {
	$string = ""; 
	$str = str_split($str); 
	
	foreach($str as $c) {
		$string .= $between . $c; 
	}
	
	return $string . $between; 
}


function kv_fun($key, $value) {
	return "$key LIKE '$value'"; 
}

function searchClient($info) { // $info is all items in a $_GET or $_POST request
    $table = "db_Clients"; 
    $keys = array("ClientId", "FirstName", "LastName", "PhoneNumber", "Email"); 
    $query_arr = array(); 
    $phone_query = ""; 
    $rows = array(); // will hold all the cases in the end

    foreach($keys as $key) {
        if(!empty($info[$key]) && $key != "PhoneNumber")
            $query_arr[$key] = $info[$key]; 
        else if(!empty($info[$key]) && $key == "PhoneNumber") {
            $value = only_numbers($info[$key]); 
            $phone_query = "(`Phone1AreaCode`='" . substr($info[$key], 0, 3) . 
                "' AND `Phone1Number` LIKE '" . insert_between_each_char(substr($info[$key], 3), "%") . "')";           
        }
    }
    
    // query string
    $query = "SELECT $table.*, db_CaseTypes.Description as Priority "
        . "FROM $table INNER JOIN db_CaseTypes ON db_CaseTypes.CaseTypeID=db_Clients.CaseTypeID WHERE "; 
    
    $query .= arr_to_str("kv_fun", " OR ", "", $query_arr) 
        . (count($query_arr) > 0 && $phone_query != "" ? " OR " : "" ). $phone_query; 
    
    $rows = query($query); 
    
	return $rows;
}
?>
