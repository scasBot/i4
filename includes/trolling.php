<?php
/*******************************
trolling.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

Description: Includes classes that are used
	for fun and to troll the users. 
	
August 2013
***********************************/

/* Inputs fillers. For example, if a contact is missing a 
	username for edits or contacts, automatically fill in 
	with a celebrity name */
class Filler {

	// returns random element of array or seed_number element
	private function random($arr, $seed_number = NULL) {
		if(!$seed_number) {
			return $arr[array_rand($arr)]; 
		} else {
			return $arr[$seed_number % count($arr)]; 
		}
	}

	// returns a random quote, seed_number unsupported now
	public function random_quote($seed_number = NULL) {
		try {
			$quote = query("SELECT * FROM i3_Quotes ORDER BY RAND() LIMIT 1"); 
			return $quote[0]["quote"]; 
		} catch (Exception $e) {
			return "\"Make each day your masterpiece.\" - John Wooden";
		}
		
/*		$quotes = query(query_select(array(
			"TABLE" => "i3_Quotes"))); 
		$tmp = array(); 
		foreach($quotes as $quote) {
			$tmp[] = $quote["quote"]; 
		}
		return $this->random($tmp, $seed_number); 
*/
	}

	private $celebs = array(
		"Michael Bluth", 
		"John Harvard", 
		"Barack Obama", 
		"Bill Gates", 
		"Amanda Bynes", 
		"Ender Wiggin",
		"Peter Wiggin", 
		"Valentine Wiggin", 
		"Bean Delphiki", 
		"Hilary Duff", 
		"Hannah Montana", 
		"Miley Cyrus"); 

	// returns a random celebrity
	public function random_celeb($seed_number = NULL) {		
		return $this->random($this->celebs, $seed_number); 
	}
} 

$filler = new Filler(); 
?>
