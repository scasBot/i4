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

// first, check if session timed out
if (!isset($_SESSION['id']))
{
    $result["Success"] = false;
}
else
{
    $result = searchClient($data);
    $result["Success"] = true;
}
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
    $set = array();
    $query_arr = array(); 
    $phone_query = ""; 
    $rows = array(); // will hold all the cases in the end

    // find which ones are set
    foreach ($keys as $key) {
        if(!empty($info[$key]))
        {
            array_push($set, $key);
        }
    }

    $notset = array_diff($keys, $set);

    $query = "SELECT db_Clients.*, db_CaseTypes.Description as Priority FROM db_Clients INNER JOIN db_CaseTypes ON db_CaseTypes.CaseTypeID=db_Clients.CaseTypeID WHERE ";

    $c = 0;

    // generate query
    foreach ($set as $key) {
        if ($c != 0)
        {
            $query .= "AND ";
        }

        if ($key == "PhoneNumber")
        {
            $areacode = substr($info[$key], 0, 3);
            $info[$key] = str_replace("(", "", $info[$key]);
            $info[$key] = str_replace(")", "", $info[$key]);
            $info[$key] = str_replace("-", "", $info[$key]);
            $phonenum = substr($info[$key], 3, 7);
            $phonenum = substr_replace($phonenum, "-", 3, 0);

            $query .= "Phone1AreaCode = '".$areacode."' AND Phone1Number = '".$phonenum."' ";
        }
        else
        {
            $query .= $key . " = '" . $info[$key] . "' ";
        }

        $c++;
    }

    $query .= "ORDER BY ClientID";

    //echo "<script>".$query."</script>";

    $rows = query($query); 
    
	return $rows;
}
?>
