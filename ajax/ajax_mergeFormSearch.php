<?php
require("../includes/client_class.php"); 

$data = $_POST["data"]; 

// check usage
if(!isset($data["ClientID"])) {
	exit; 
}

try {
	$clientNumber = $data["clientNumber"]; 
	$client = new Client($data["ClientID"]); 
	require("../templates/merge_form_fillable.php"); 
} catch (Exception $e) {
	exit; 
}
?>