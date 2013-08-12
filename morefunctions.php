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
		
	$passing_strings = array(
		"", 
		" ", 
		"David Joyner <davidbilljoyner@gmail.com>, Diana Carrillo <Diana.carrillo@scouts.org.mx>, Dylan Davies <dylaneric94@hotmail.com>, Grecia Barcena <grecia.barcena@scouts.org.mx>, Keegan Eatmon <kneatmon@hotmail.com>, Luis Antonio Aguayo <luis.aguayo@scouts.org.mx>, Meghan Pierson <zebramep@gmail.com>, Patrick Claytor <patrick.claytor@gmail.com>, Victoria McCormick <torimcc@gmail.com>",
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
		"willy@chenxiao.us.", 
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