<?php
/*******************************
mailer_class.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013
***********************************/

define("FAKE_EMAIL_FILE", ROOT . "/i4FakeEmails.txt"); 

function fakeMail($to, $subject, $msg, $headers) {
	try {
		$handle = fopen(FAKE_EMAIL_FILE, "a"); 
		fwrite($handle, json_encode(array("to" => $to, "subject" => $subject, 
			"message" => $msg, "headers" => $headers)) . "\n"); 
		fclose($handle);
		return true; 
	} catch (Exception $e) {
		return false; 
	}
}

class Mailer {
	protected $recipients = array(); 
	protected $sender = ""; 
	protected $sbj = ""; 
	protected $msg = ""; 
	protected $senderName = "";

	public function to($emails) {
		if($this->isValidEmail($emails)) {
			array_push($this->recipients, $emails); 
		} else {
			throw new Exception("'To' field incorrect. Multipls recipients not supported at" . 
				"this time."); 
		}
	}
	
	public function from($email) {
		if($this->isValidEmail($email)) {
			$this->sender = $email; 
		} else {
			return false; 
		}
	}
	
	public function subject($sbj) {
		$this->sbj = $sbj; 
	}
	
	public function message($msg) {
		$this->msg = $msg; 
	}
		
	public function senderName($senderName) {
		$this->senderName = $senderName;
	}

	public function send() {
//		if(LOCAL_HOST) {
//			return fakeMail($this->recipients, 
//				$this->sbj, $this->msg, 
//				"From: " . $this->sender); 
//		} else {

		// change up "from" if we have a sender name
		if ($this->senderName != "")
		{
			$this->sender = $this->senderName . " <" . $this->sender . ">";
		}
	
		return mail($this->recipients[0], 
			$this->sbj, 
			$this->msg, 
			"From: " . $this->sender); 
//		}
	}
	
	public function isValidEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL); 
	}
}

/* Not used right now
//This is a function that takes a string of emails and put it into one array	
function parseEmailString($string) {
	try {
		$string = trim($string); 
		if(strlen($string) == 0) {
			return null; 
		}
		$mailarray = explode(",", $string);
		if(!is_array($mailarray)) {
			return null; 
		}

		$goodmails = array();
		$index = array(); 
		
		foreach($mailarray as $email){
			$email = parseEmail($email); 
			if(!isset($index[$email])) {
				array_push($goodmails, $email); 
				$index[$email] = ""; 
			}	
		}
		return $goodmails;
	} catch (Exception $e) {
		throw new Exception("Function 'parseEmailString' failed with: [" . $e->getMessage() . "]"); 
	}
}

function parseEmail($email) {
	try {
		$start = strpos($email,"<");
		if ($start) { 
			$end = strpos($email,">");
			if(!$end) {
				throw new Exception("Invalid email " . $email); 
			}
			$email = substr($email,$start + 1, ($end - $start) - 1);
		}
		$email = trim($email); 
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return $email; 
		} else {
			throw new Exception("Inavlid email " . $email); 
		}
	} catch (Exception $e) {
		throw new Exception("Function 'parseEmail' failed with:[" . $e->getMessage() . "]"); 
	}
}
*/
?>
