<?php
class Filler {

	private function random($arr, $seed_number = NULL) {
		if(!$seed_number) {
			return $arr[array_rand($arr)]; 
		}
		else {
			return $arr[$seed_number % count($arr)]; 
		}
	}

	private $quotes = array(
		"Freedom lies in being bold - Robert Frost", 
		"Not all who wonder are lost - J.R.R. Tolkein", 
		"Waddup - Willy Xiao", 
		"Everything has beauty but not everyone sees it - Confucius", 
		"Be a yardstick of quality. Some people aren't used to an environment where excellence is expected - Steve Jobs");
		
	public function random_quote($seed_number = NULL) {		
		return $this->random($this->quotes, $seed_number); 
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
	
	public function random_celeb($seed_number = NULL) {		
		return $this->random($this->celebs, $seed_number); 
	}
} 

$filler = new Filler(); 
?>
