<?php
function fakeMail($to, $subject, $msg, $headers) {
	try {
		$handle = fopen(FAKE_EMAIL_FILE, "a"); 
		fwrite($handle, json_encode(array("to" => $to, "subject" => $subject, 
			"message" => $msg, "headers" => $headers))); 
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

	public function to($emails) {
		$this->recipients = $emails; 
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
	
	public function send() {
		if(ON_LOCAL_HOST) {
			return fakeMail($this->recipients, 
				$this->sbj, $this->msg, 
				"From: " . $this->sender); 
		} else {		
			return mail($this->recipients, 
				$this->sbj, 
				$this->msg, 
				"From: " . $this->sender); 
		}
	}
	
	public function isValidEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL); 
	}
}
?>
