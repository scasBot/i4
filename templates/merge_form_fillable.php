<h3 style='border-bottom: 1px solid black'><?php echo "Client " . $clientNumber ?></h3>

<?php
	function printRow($title, $data) {
		echo "<div class='row'>"; 
		echo "<div class='span2'>"; 
		echo $title; 
		echo "</div><div class='span2'>"; 
		echo $data; 
		echo "</div></div>"; 
	}
	
	function printRow2($title, $id, $info) {
		printRow("<p>" . $title . "</p>", "<p id='" . createId($id) . "'>" . $info . "</p>"); 
	}
?>
<?php
printRow2("Client ID:", "ClientID", $client->get_id()); 
printRow2("First Name:", "FirstName", $client->get("info")->get("FirstName")); 
printRow2("Last Name:", "LastName", $client->get("info")->get("LastName")); 
printRow2("Primary Phone:", "Phone1Number", $client->get("info")->get("Phone1Number")); 
printRow2("Secondary Phone:", "Phone2Number", $client->get("info")->get("Phone2Number")); 
printRow2("Email:", "Email", $client->get("info")->get("Email")); 
?>



