<?php
    //This is a function that takes a string of emails and put it into one array
	
	function parseEmails($string) {
		// first turn the email string into email array.
		$mailarray = explode(",", $string);
		// then filter through the array for none-email formats and return the result array of mail addresses.
		$goodmails = array();
		foreach($mailarray as $email){
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				array_push($goodmails, $email);
			}
		}
		return $goodmails;
	}
	//parseEmails($string);
?>

