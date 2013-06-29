<?php

// <option value=val>key</option>
function htmlOption($key, $val, $selected = false) {
	$html = "<option value=\"" . $val . "\" " . ($selected ? "selected" : "") . " >" . $key . "</option>"; 
	return $html; 
}

// <option value=$arr->$val>$arr->$key</option> ... 
function htmlOptions($arr, $selected_key = NULL) {
	
	// ensure the selected key (if any) is in the array
	assert2(func_num_args() < 2 || isset($arr[$selected_key]), 
		"key: " . $selected_key . " not in array"); 

	// create the options
	$html = ""; 
	foreach($arr as $key => $val) {
		$html .= htmlOption($key, $val, $selected_key == $key); 
	}
	
	return $html; 
}

// <option value="AL">AL</option>...<option value="WV">WV</option>
function htmlOptionsStates($state) {
	return htmlOptions(
		array("GA" => "GA", 
			"MA" => "MA", 
			"FL" => "FL", 
			"NY" => "NY", 
			"TX" => "TX"), 
		$state); 
}
?>