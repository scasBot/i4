<?php
	function assert2($predicate, $description = "Assert Failure") {
		if(!$predicate) {
			throw new Exception($description); 
		} else {
			echo "Assert passed!"; 
		}
	}

    //This is a function that takes a string of emails and put it into one array
	
	function parseEmails($string) {
		// first, tidy up the whitespaces.
		$rawarray = str_replace(" ","",$string);
		// then, clean up the contents outside of <...>
		$mailarray = explode(",", $rawarray);
		// then filter through the array for none-email formats and return the result array of mail addresses.
		$goodmails = array();
		foreach($mailarray as $email){
			$start = strpos($email,"<");
			if ($start != FALSE) {
				$end = strpos($email,">");
				$email = substr($email,$start,$end-$start);
				$email = str_replace("<","",$email);
			}
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				array_push($goodmails, $email);
			} else {
				throw new Exception("Invalid email: " . $email); 
			}
		}
		return $goodmails;
	}
	
	$passing_strings = array(
		"willy@chenxiao.us", 
		"willy@chenxiao.us, tom@bob.com",
		"willy@chenxiao.us,      tom@bob.com", // multiple spaces 		
		"willy xiao <willy@chenxiao.us>, tom bob <tom@bob.com>", 
		"willy@chenxiao.us, tom bob <tom@bob.com>", 
		"wxiao@college.harvard.edu", 
		"wxiao.debate@gmail.com", 
		"willy@chenxiao.us, bob@tom.com, tom@bob.com", 
		"willy@chenxiao.us, willy@chenxiao.us"
	); 
	$failing_strings = array(
		"willy", 
		"google.com", 
		"@google.com", 
		"willy@", 
		"willy@chenxiao.us tom@bob.com", 
		"willy@chenxiao.us willy xiao <tom@bob.com>", 
		"willy@chenxiao.us, <willy xiao>, tom@bob.com", 
		"willy@chenxiao.us, tom@bob.com, ble"
	); 
	
	foreach($passing_strings as $str) {
		echo "<p>".$str; 
		var_dump(parseEmails($str)); 
		echo "</p>"; 
	}
	
	foreach($failing_strings as $str) {
		try {
			echo "<p>Failed: "; 
			var_dump(parseEmails($str));
			echo "</p>"; 
		} catch (Exception $e) {
			echo "<p>Successfully thrown error on : " . $str . "</p>"; 
		}
	}
	
?>

