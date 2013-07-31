<?php
	function assert2($predicate, $description = "Assert Failure") {
		if(!$predicate) {
			throw new Exception($description); 
		} else {
			echo "Assert passed!"; 
		}
	}

    //This is a function that takes a string of emails and put it into one array
	
	function parseEmailString($string) {
		// first, tidy up the whitespaces.
//		$rawarray = str_replace(" ","",$string);
		// then, clean up the contents outside of <...>
		$mailarray = explode(",", $string);

		// then filter through the array for none-email formats and return the result array of mail addresses.
		$goodmails = array();
		$index = array(); 
		
		foreach($mailarray as $email){
			try { 
				/* WSX COMMENT: almost exactly the same as your original 
					function, except this erases duplicates */
				$email = parseEmail($email); 
				if(!isset($index[$email])) {
					array_push($goodmails, $email); 
					$index[$email] = ""; 
				}	
			} catch (Exception $e) {
				throw new Exception("Function 'parseEmailString' failed with: [" . $e->getMessage() . "]"); 
			}
		}
		return $goodmails;
	}

	function parseEmail($email) {
		$start = strpos($email,"<");
		if ($start) { 
			/* WSX COMMENT: saying $start != FALSE is the 
				equivalent of saying $start == true, which is the equivalent 
				of saying just "$start" */

			$end = strpos($email,">");
			$email = substr($email,$start,$end-$start);
			$email = str_replace("<","",$email);
		}
		$email = trim($email); 
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return $email; 
		} else {
			throw new Exception("Function 'parseEmail' failed with: [Invalid email: " . $email . "]"); 
		}
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
		"willy@chenxiao.us, willy@chenxiao.us", 
		"willy@chenxiao.us willy xiao <tom@bob.com>", 		
	); 
	$failing_strings = array(
		"willy", 
		"google.com", 
		"@google.com", 
		"<willy@chenxiao.us> <tom@bob.com>",
		"<willy@chenxiao.us> willy xiao, <willy@chenxiao.us> <tom, willyxiao <willy@chenxiao.us>",
		"willy@", 
		"willy@ chenxiao.us", 
		"willy@chenxiao.us tom@bob.com", 
		"willy@chenxiao.us, <willy xiao>, tom@bob.com", 
		"willy@chenxiao.us, tom@bob.com, ble",
		"willy@chenxiao.us, , tom@bob.com"
	); 

	foreach($passing_strings as $str) {
		echo "<p>".$str; 
		var_dump(parseEmailString($str)); 
		echo "</p>"; 
	}
	
	foreach($failing_strings as $str) {
		try {
			var_dump(parseEmailString($str));
			echo "<p>Failed to throw Error on " . $str . "</p>"; 
		} catch (Exception $e) {
			echo "<p>Successfully thrown error on : " . $str . " " . $e->getMessage() . "</p>"; 
		}
	}
	
?>

