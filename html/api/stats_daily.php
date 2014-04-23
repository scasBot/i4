<?php
require("api_includes/api_config.php"); 

header("Content Type: text/json"); 

if(!READ_AUTH) {
	error("Unauthorized access."); 
}

echo pretty_json(json_encode(model("user_stats.php", 
	array("StartDate" => "SUBDATE(CURRENT_DATE(), 1)", 
		"EndDate" => "CURRENT_DATE()")))); 
?>