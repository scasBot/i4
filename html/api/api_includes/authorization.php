<?php

// reading and writing authorizations
define("READ_AUTH", isset($data["READ_AUTH"]) 
	&& $data["READ_AUTH"] === API_READ_AUTH); 

define("WRITE_AUTH", isset($data["WRITE_AUTH"]) 
	&& $data["WRITE_AUTH"] === API_WRITE_AUTH); 

define("ACCESS_AUTH", isset($data["ACCESS_AUTH"]) 
	&& $data["ACCESS_AUTH"] === API_ACCESS_AUTH); 
	
?>