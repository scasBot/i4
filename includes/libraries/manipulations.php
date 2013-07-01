<?php
function reduce_kv($callback, $initial, $arr) {
	$return = $initial; 

	foreach($arr as $key => $value) {
		$return = $callback($key, $value, $return); 
	}
	
	return $return; 
}

function map_kv($callback, $arr) {
	$return = array(); 

	foreach($arr as $key => $value) {
		$return = array_merge($return, (array) $callback($key, $value)); 
	}
	
	return $return; 
}

/** converts an array to a string with the function $kv_fun passed in a $key => $value pair 
 * and then adding either the $concat or the $end string to the end of each pair from $arr
 **/
function arr_to_str($kv_fun, $concat, $end, $arr) {
	$str = ""; 
	$i = 0; 
	$total = count($arr); 
	
	foreach($arr as $key => $val) {
		$str .= $kv_fun($key, $val); 
		$str .= ($i == $total - 1 ? $end : $concat); 
		$i++; 
	}
	
	return $str; 
}

function only_numbers($str) {
	return preg_replace("/[^0-9]/", "", $str); 
} 
?>