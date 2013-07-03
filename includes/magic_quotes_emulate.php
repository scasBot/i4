<?php
// copied from http://php.net/manual/en/security.magicquotes.disabling.php
// used to process all strings in global functions
// can be used to emulate the SCAS hcs.harvard.edu server which runs php 5.2.4
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

if(get_magic_quotes_gpc() != 1) {
	process_global_strings("addslashes"); 
}

?>
