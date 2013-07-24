<?php


// <li id='$id'>$text</li>
function htmlLi($text, $id) {
	$html = "<li id='$id'>$text</li>"; 
	return $html; 
}

// <li id='$arr->key'>$arr->val</li>...
function htmlLis($arr) {
	$html = ""; 
	
	foreach($arr as $id => $text) {
		$html .= htmlLi($text, $id); 
	}
	
	return $html; 
}

// <option value=val>key</option>
function htmlOption($text, $val, $selected = false) {
	$html = "<option value='" . $val . "' " . ($selected ? "selected" : "")
		. " >" . $text . "</option>"; 
	
	return $html; 
}

// <option value=$arr->$val>$arr->$key</option> ... 
function htmlOptions($arr, $selected_text = NULL) {
	
	// ensure the selected key (if any) is in the array
	assert2(func_num_args() < 2 || in_array($selected_text, $arr),  
		"key: " . $selected_text . " not in array"); 

	// create the options
	$html = ""; 
	foreach($arr as $val => $text) {
		$html .= htmlOption($text, $val, $selected_text == $text); 
	}
	
	return $html; 
}

// <option value="AL">AL</option>...<option value="WV">WV</option>
function htmlOptionsStates($state) {
	return htmlOptions(
		array(
			"AL" => "AL",
			"AK" => "AK",
			"AR" => "AR",
			"AZ" => "AZ",
			"CA" => "CA",
			"CO" => "CO",
			"CT" => "CT",
			"DE" => "DE",
			"FL" => "FL",
			"GA" => "GA",
			"HI" => "HI",
			"IA" => "IA",
			"ID" => "ID",
			"IL" => "IL",
			"IN" => "IN",
			"KS" => "KS",
			"KY" => "KY",
			"LA" => "LA",
			"MA" => "MA",
			"MD" => "MD",
			"ME" => "ME",
			"MI" => "MI",
			"MN" => "MN",
			"MO" => "MO",
			"MS" => "MS",
			"MT" => "MT",
			"NC" => "NC",
			"ND" => "ND",
			"NE" => "NE",
			"NH" => "NH",
			"NJ" => "NJ",
			"NM" => "NM",
			"NV" => "NV",
			"NY" => "NY",
			"OH" => "OH",
			"OK" => "OK",
			"OR" => "OR",
			"PA" => "PA",
			"RI" => "RI",
			"SC" => "SC",
			"SD" => "SD", 
			"TN" => "TN",			
			"TX" => "TX",
			"UT" => "UT",
			"VA" => "VA",
			"VT" => "VT",
			"WA" => "WA",
			"WI" => "WI",
			"WV" => "WV",
			"WY" => "WY"), 
		$state); 
}
?>