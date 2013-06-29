<?php
/***************
* SCAS i4
*
* ALL library functions
*
****************/

function check_assert_handler($description = NULL) {

	// <<<EDIT CODE HERE >>> //
	$msg = "Assert Failure: " . 
		($description ? $description : debug_backtrace()) ; 
	apologize($msg); 
	// <<<END EDIT HERE >>> //

}

// <<EDIT DEFINITIONS HERE>> //
define("QUERY_DATABASE", DATABASE);
define("QUERY_PASSWORD", PASSWORD);
define("QUERY_SERVER", SERVER);
define("QUERY_USERNAME", USERNAME);
// << END EDIT HERE >> //

require("check.php"); 
	/* functions that check code is valid (e.g. assert statements) */

require("html.php"); 
	/* all functions begin with html and are written in camelCase */

require("query.php"); 
	/* all functions begin with query and are written in php_case */

?>