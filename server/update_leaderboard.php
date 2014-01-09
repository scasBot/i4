<?php
	require("server_config.php"); 
	define("LIMIT", 20); 
		
	$contacts = query(
		"SELECT * " 
		. "FROM `dbi4_Contacts` "
		. "JOIN `i3_Users` "
		. "ON dbi4_Contacts.UserAddedID=i3_Users.UserID "
		. "WHERE YEAR(ContactDate) >= YEAR(CURRENT_DATE)"); 
	
	$users = array(); 
	$total = array("big"=>0, "medium"=>0, "small"=>0); 
	
	if(!$contacts) {
		exit; 
	} else {
		foreach($contacts as $contact) {
			$id = $contact["UserID"]; 
		
			if(!isset($users[$id])) {
				$users[$id]["big"] = 0; 
				$users[$id]["medium"] = 0; 
				$users[$id]["small"] = 0;
				$users[$id]["name"] = $contact["UserName"]; 
			}			
			switch((int) $contact["ContactTypeID"]) {
				case 12 : // called, helped by phone
				case 16 : // email response sent
				case 20 : // called received, helped by phone
				case 30 : // met with client
					$users[$id]["big"]++; 
					$total["big"]++; 
				case 10 : // called, left message
				case 11 : // called, no answer
				case 13 : // called, wrong number
				case 14 : // called, number not in service
				case 92 : // case referred to LR
				case 97 : // assistance not required
				case 31 : // appointment scheduled
					$users[$id]["medium"]++; 
					$total["medium"]++; 
				case 1 : 
				case 21 : 
				case 15 : 
					$users[$id]["small"]++; 
					$total["small"]++; 
			}
		}
		
		function sort_by($size, $a, $b) {return $b[$size] - $a[$size];}
		function sort_big($a, $b) {return sort_by("big", $a, $b);}
		function sort_medium($a, $b) {return sort_by("medium", $a, $b);}
		function sort_small($a, $b) {return sort_by("small", $a, $b);}
		function get_users($users, $size) {
			$i = 0; 
			$result = array(); 
			foreach($users as $user) {
				if($i < LIMIT) {
					$result[] = array("UserName" => $user["name"], 
						"Number" => $user[$size]); 
					$i++; 
				} else {
					return $result; 
				}
			}
			
			return $result; 
		}
		
		$stats = array(); 
		usort($users, "sort_big"); 
		$stats["big"] = get_users($users, "big"); 
		usort($users, "sort_medium"); 
		$stats["medium"] = get_users($users, "medium"); 
		usort($users, "sort_small"); 
		$stats["small"] = get_users($users, "small"); 

		file_put_contents(LEADERBOARD_STATS_FILE, json_encode(array("total"=>$total, "stats"=>$stats, "date"=>date("F jS")))); 
	}
?>
