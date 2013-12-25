<?php
	// ensure required fields are set
	if(!isset($data["to"], $data["from"])) {
		echo "Error: 'to' or 'from' not set."; 
		die(); 
	}
	
	extract($data); 
	
	require("../includes/mailer_class.php"); 
	require("../includes/profile_class.php");
	$mailer = new Mailer(); 	
	$profile = new Profile($id);
	
	if(!($from == $profile->get("Email") || $from == SCAS_EMAIL || $from == "donotreply@masmallclaims.org")) {
		die_with_error("The email " . $from . " is currently unverified as yours."); 
	} else if (!$to) {
		die_with_error("You must input something in the to field."); 
	}

	$mailer->to($to); 
	$mailer->senderName($senderName);
	$mailer->from($from); 
	$mailer->subject($subject); 
	$mailer->message($message);

	
	if(!$mailer->send()) {
		echo "Error: sending failed."; 
		die(); 
	} else {
		echo json_encode(array("Success" => true)); 
		die(); 
	}
?>
