<?php
	function assert2($predicate, $line = __LINE__) {
		if(!$predicate) {
			throw new Exception("Assert failure: line: " .  $line); 
		}
	}
	
	function test($arr, $line) {
		global $string; 
		assert2(parseEmails($string) == $arr, $line); 
	}
	
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
	
	$string = "willy@chenxiao.us";
	test(array("willy@chenxiao.us"), __LINE__); 
	$string .= ","; 
	test(array("willy@chenxiao.us"), __LINE__); 
	$string .= "tommy@bob.com"; 
	test(array("willy@chenxiao.us", "tommy@bob.com"), __LINE__); 
?>