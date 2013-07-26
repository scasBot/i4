<?php
	// ensure required fields are set
	if(!isset($data["to"], $data["from"])) {
		echo "Error: to or from not set."; 
		die(); 
	}
	
	define("FAKE_EMAIL_FILE", "../../i4FakeEmail.txt"); 
	require("../includes/mailer_class.php"); 
	$mailer = new Mailer(); 
	
	$mailer->to($data["to"]); 
	$mailer->from($data["from"]); 
	$mailer->subject($data["subject"]); 
	$mailer->message($data["message"]); 
	
	if(!$mailer->send()) {
		echo "Error: sending failed."; 
		die(); 
	} else {
		echo json_encode(array("Success" => true)); 
		die(); 
	}
?>