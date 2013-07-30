<?php
// configuration
require("../includes/config.php"); 

// for the captcha
require("../includes/recaptchalib.php");
 
$public_key = "6LedVuUSAAAAAOndq0FREOZhLogrL1S1b1WdSBXD"; 
$private_key = "6LedVuUSAAAAAJSkG6kZpKLfQyTQhtRhQhcSolz8"; 

$captcha = recaptcha_get_html($public_key); 
								
if($_SERVER["REQUEST_METHOD"] == "GET") {
	$warning = ""; 

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
	
	$resp = recaptcha_check_answer ($private_key,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);			
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
		} else if(!$resp->is_valid) {
			throw new Exception("Captcha was incorrect."); 
		}
		
		$warning = ""; 
	} catch(Exception $e) {
		$warning = $e->getMessage() . " Please try again."; 
	}
	//** DO STUFF WITH EMAIL **//
	
	
/*
	function display($page_name) {
		require(ROOT . "/templates/static_" . $page_name); 
	}
	
	display("email_thanks.php"); 
*/	
//	require(ROOT . "/templates/" . "); 
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
	"warning" => $warning, 
	"captcha" => $captcha));
?>