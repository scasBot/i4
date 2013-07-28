<?php
// configuration
require("../includes/config.php"); 

if($_SERVER["REQUEST_METHOD"] == "GET") {
	$warning = false; 

	$FirstName = ""; 
	$LastName = ""; 
	$Email = ""; 
	$Subject = ""; 
	$Message = ""; 
	$Phone = ""; 
	$Zip = ""; 
	$Contacted = ""; 		

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	extract($_POST); 

	if(!isset($Contacted)) {
		$Contacted = ""; 
	}
	
	try {
		if(empty($FirstName)) {
			throw new Exception("First Name was empty."); 
		} else if (empty($LastName)) {
			throw new Exception("Last Name was empty."); 
		} else if (empty($Subject)) {
			throw new Exception("Subject was empty."); 
		} else if (empty($Message)) {
			throw new Exception("Message was empty."); 
		} else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			throw new Exception("Email was invalid."); 
		}
	} catch(Exception $e) {
		$warning = $e->getMessage(); 
	}

	//** DO STUFF WITH EMAIL **// 

	function display($page_name) {
		require(ROOT . "/templates/static_" . $page_name); 
	}
	
	display("email_thanks.php"); 
	
	require(ROOT . "/templates/" . "
}

render("email_form.php", 
array("title" => "Email", 
	"FirstName" => $FirstName, 
	"LastName" => $LastName, 
	"Email" => $Email, 
	"Subject" => $Subject, 
	"Message" => $Message, 
	"Phone" => $Phone, 
	"Zip" => $Zip, 
	"Contacted" => $Contacted, 
	"warning" => $warning));
?>