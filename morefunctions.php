<?php

	$string = "willy@chenxiao.us, wxiao@college.harvard.edu, willyxiao.debate@gmail.com";
    //This is a function that takes a string of emails and put it into one array
	
	function parseEmails($string) {
		// first turn the email string into email array.
		$mailarray = explode(",", $string);
		// then filter through the array for none-email formats and return the result array of mail addresses.
		$goodmails = array_filter($mailarray,filter_var_array($mailarray, FILTER_VALIDATE_EMAIL));
		return $goodmails;
	}
?>