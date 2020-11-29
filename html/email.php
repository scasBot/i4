<?php
// configuration
require("../includes/config.php"); 

// PHP Mailer library
require("../vendor/php-mailer/src/Exception.php");
require("../vendor/php-mailer/src/PHPMailer.php");
require("../vendor/php-mailer/src/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
								
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
		
		$warning = ""; 
	} catch(Exception $e) {
		$warning = $e->getMessage() . " Please try again."; 
	}

	//** DO STUFF WITH EMAIL **//
	$mail = new PHPMailer();
	// configure an SMTP
	$mail->isSMTP();
	if (LOCAL_HOST) {
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;
	} else {
		$mail->SMTPDebug = SMTP::DEBUG_OFF;
	}

	$mail->Host = "smtp.gmail.com";
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	$mail->Username = GMAIL_USERNAME;
	$mail->Password = GMAIL_PASSWORD;
	$mail->Port = 587;

	$mail->setFrom(GMAIL_USERNAME, "MA Small Claims Advisory Service");
	$mail->addAddress($Email, $FirstName . " " . $LastName);
	$mail->Subject = $Subject;
	// Set HTML
	// $mail->isHTML(TRUE);
	$mail->Body = $Message;
	// $mail->AltBody = "Testing testing 123";
	// send the message
	if(!$mail->send()){
		echo "Message could not be sent.";
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message has been sent";
	}
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