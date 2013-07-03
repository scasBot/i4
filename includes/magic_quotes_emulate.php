<?php
// copied from http://php.net/manual/en/security.magicquotes.disabling.php
// used to emulate the SCAS hcs.harvard.edu server which runs php 5.2.4
function process_global_strings($func) {
	$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	while (list($key, $val) = each($process)) {
		foreach ($val as $k => $v) {
			unset($process[$key][$k]);
			if (is_array($v)) {
				$process[$key][$func($k)] = $v;
				$process[] = &$process[$key][$func($k)];
			} else {
				$process[$key][$func($k)] = $func($v);
			}
		}
	}
	unset($process);
}

/**********
* for some reason you can't just do : 
* if(!get_magic_quotes_gpc()) {special_character_fix(addslashes)}; 
*
************/
if(get_magic_quotes_gpc() != 1) {
	process_global_strings("addslashes"); 
}

/******* other method is better!
if (get_magic_quotes_gpc()) {
	special_character_fix("stripslashes"); 
} 
***************/
?>
