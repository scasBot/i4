<?
/*******************************
i4_database_constants.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

April 2014

Description : 
***********************************/

// this must match the MySQL Database!
class ContactTypeID {
	protected $ids = array(
		"Create client record" => 1,
		"Create new case record" => 2,
		"Called, left message" => 10,
		"Called, no answer" => 11,
		"Called, helped by phone" => 12,
		"Called, wrong number" => 13,
		"Case referred to external agency" => 90,
		"Call received, helped by phone" => 20,
		"Voicemail received" => 21,
		"Case referred to GBLS Office" => 91,
		"Case referred to Legal Research" => 92,
		"Case marked complete" => 99,
		"Case referred to PBH Office" => 93,
		"Legal Research replied to question" => 24,
		"Met with client" => 30,
		"Assistance not required" => 97,
		"Appointment scheduled" => 31,
		"Email Received" => 15,
		"Email, Response Sent" => 16,
		"Called, number not in service" => 14,
	);
	
	protected $visible = array(1,10,11,12,13,29,21,92,30,97,31,15,16,14);
	protected $client_assisted = array(10,12,16,20,24,30,90,91,93,99);
	protected $client_assisted_by_phone = array(12,20,24,90,91,93);
	
	private function to_format($arr, $format) {
		if (count($arr) == 1) {
			return $arr[0]; 
		}
		
		switch ($format) {
			case "PHP":
				return $arr; 
			break;
			case "JSON": 
				return json_encode($arr); 
			break;
			case "MYSQL": 
				if (!function_exists("anon")) {
					function anon($key,$val) {
						return $val;
					}
				}
				
				return "(" . arr_to_str("anon", ",", "", $arr) . ")"; 
			break;
			default: 
				throw new Exception("Format doesn't exist!");
		}
	}
	
	// always returns an array unless 1 element
	public function get_id_of($descriptor, $format = "PHP") {
		if (array_key_exists($descriptor, $this->ids)) {
			return $this->to_format(array($this->ids[$descriptor]), $format); 
		} else if (property_exists('ContactTypeID', $descriptor)) {
			return $this->to_format($this->$descriptor, $format); 
		} else {
			throw new Exception("ContactTypeID descriptor doesn't exist"); 
		}
	}
}

?>

