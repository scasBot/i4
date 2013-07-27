<?php

// my assert function 
function assert2($statement, $description = NULL) {
	if (!$statement) {
		check_assert_handler($description); 
	}
}
?>