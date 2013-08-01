<h3 style='border-bottom: 1px solid black'><?php echo "Client " . $client->get_id(); ?></h3>
<?php
/*
if(!function_exists("createId")) {
	function createId($str) {
		global $clientNumber; 
		return $str . $clientNumber; 
	}
}*/
	echo $clientNumber; 
	
	function createId($str) {
		global $clientNumber; 
		echo $clientNumber; 
		return $str . $clientNumber; 
	}	
	
if(!function_exists("printRow")) {
	function printRow($title, $data) {
		echo "<div class='well well-small mergeinfo'>"; 
		echo "<div class='row'>"; 
		echo "<div class='span3'>"; 
		echo $title; 
		echo "</div></div><div class='row'><div class='span3'>"; 
		echo $data; 
		echo "</div></div></div>"; 
	}
}
if(!function_exists("printRow2")) {
	function printRow2($title, $id, $info) {
		printRow("<p style='text-align: left; font-weight: bold'>" . $title . "</p>", 
			"<p id='" . createId($id) . "' style='text-align: left'>" . $info . "</p>"); 
	}
}
?>
<div class='merge-form-fillable' class='merge-form-fillable' 
	data-clientNumber='<?php echo $clientNumber ?>' >
<?php
// printRow2("ID:", "ClientID", $client->get_id()); 
printRow2("First Name:", "FirstName", $client->get("info")->get("FirstName")); 
printRow2("Last Name:", "LastName", $client->get("info")->get("LastName")); 
printRow2("Primary Phone:", "Phone1Number", $client->get("info")->get("Phone1Number")); 
printRow2("Secondary Phone:", "Phone2Number", $client->get("info")->get("Phone2Number")); 
printRow2("Email:", "Email", $client->get("info")->get("Email")); 
printRow2("Address:", "Address", $client->get("info")->get("Address")); 
printRow2("City:", "City", $client->get("info")->get("Address")); 
printRow2("State:", "State", $client->get("info")->get("State")); 
printRow2("Zip:", "Zip", $client->get("info")->get("Zip")); 
printRow2("Language:", "Language", $client->get("info")->get("Language")); 
printRow2("Notes:", "Notes", $client->get("info")->get("ClientNotes"));
?>
</div>
<style type="text/css">
.mergeinfo:hover {
	cursor: pointer
}
</style>


