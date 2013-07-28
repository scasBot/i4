<?php
define("EMAILS_FILE", ROOT . "/data/emails.php"); 
define("LOCK", dirname(__FILE__) . "/clientEmailsLOCK.lock"); 
define("UNLOCK_LIMIT", 5);
define("SLEEP_NANOSECS", 150000000); 

with_lock(0); 

function with_lock($unlock_attempts) {
	if($unlock_attempts > UNLOCK_LIMIT) {
		try {
			unlink(LOCK); 
		} catch (Exception $e) {
			throw new Exception("Too many unlock attempts, and" . 
				" breaking lock failed with: " . $e->getMessage()); 
		}
		with_lock($unlock_attempts - 1); 			
	} else if(file_exists(LOCK)) {
		time_nanosleep(0, SLEEP_NANOSECS); 
		with_lock($unlock_attempts + 1); 
	} else {
		try {
			file_put_contents(LOCK, "true"); 
			main_event(); 
			unlink(LOCK); 
		} catch (Exception $e) {
			if(file_exists(LOCK)) {
				unlink(LOCK); 
			}
			throw new Exception("Main function runtime failed with: " . $e->getMessage()); 
		}
	}
}

function main_event() {
	global $data; 

	switch ($data["action"]) {
		case "GET" : 
			try {
				$handle = fopen(EMAILS_FILE, "r"); 
				$result = array(); 
				for($line = fgets($handle); $line; $line = fgets($handle)) {
					$result[] = json_decode($line, true); 
				}
				fclose($handle); 
				echo json_encode($result);
			} catch (Exception $e) {
				fclose($handle); 
				throw new Exception("Server failure: " . $e->getMessage()); 
			}
		break; 
		case "UPDATE" : 
			try {
				$handle = fopen(EMAILS_FILE, "r"); 
				$result = array(); 
				for($line = fgets($handle); $line; $line = fgets($handle)) {
					$tmp = json_decode($line, true); 
					if(!$tmp["date"] == $data["date"]) {
						$result[] = $tmp; 
					}
				}
				fclose($handle); 
			} catch (Exception $e) {
				fclose($handle); 
				throw new Exception("Reading failure: " . $e->getMessage()); 
			}

			try {
				$handle = fopen(EMAILS_FILE, "w"); 
				foreach($result as $line) {
					fwrite($handle, json_encode($line) . "\n"); 
				}
				fclose($handle); 
				echo json_encode(array("Success" => true)); 
			} catch (Exception $e) {
				fclose($handle); 
				throw new Exception ("Writing failure: " . $e->getMessage()); 
			}
		break;
		default :
			ajax_error("Sorry, wrong action type."); 
		break; 
	}
}
?>