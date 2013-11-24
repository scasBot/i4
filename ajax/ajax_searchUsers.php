<?php

define("LIMIT", 100); 

$query = "SELECT DISTINCT UserID, UserName, Email FROM i3_Users WHERE "; 

if(isset($data["hidden"])) {
	$query .= "Hidden=" . (($data["hidden"]) ? 0 : 1) . " AND "; 
}

if(isset($data["comper"])) {
	$query .= " Comper=" . (($data["comper"]) ? 0 : 1) . " AND "; 
}

if(isset($data["yog"]) && $data["yog"] > 0) {
	$query .= " YOG=" . $data["yog"] . " AND "; 
}

if(isset($data["search"])) {
	$query .= "(LOWER(UserName) REGEXP '" . strtolower($data["search"]) . "' OR "
		. "LOWER(Email) REGEXP '" . strtolower($data["search"]) . "')"; 
}

$query .= " ORDER BY UserName"; 
$results = query($query); 

if(!$results) {
	die(); 
} else if(count($results) > LIMIT) {
	echo "1"; // too many results
	die(); 
} else {
	echo json_encode($results); 
	die(); 
}
?>