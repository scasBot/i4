<?php
/*******************************
constants_passwords.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : 
	Acquires the passwords for the database. 
***********************************/

$pw_string = file_get_contents(PASSWORDS_FILE); 

try {
	$pw_json = json_decode($pw_string, true); 
} catch(Exception $e) {
	die("Error decoding passwords file, email: " . ADMIN_EMAIL . " for further assistance."); 
}

define("AJAX_HASH", $pw_json["AJAX_HASH"]); 

define("DATABASE", $pw_json["MYSQL"]["DATABASE"]); 
define("PASSWORD", $pw_json["MYSQL"]["PASSWORD"]); 
define("SERVER", $pw_json["MYSQL"]["SERVER"]); 
define("USERNAME", $pw_json["MYSQL"]["USERNAME"]);

define("API_READ_AUTH", $pw_json["API_READ_AUTH"]);
define("API_WRITE_AUTH", $pw_json["API_WRITE_AUTH"]); 
define("API_ACCESS_AUTH", $pw_json["API_ACCESS_AUTH"]); // this should be hidden to public

define("TWILIO_ACCOUNT_SID", $pw_json["TWILIO"]["ACCOUNT_SID"]);
define("TWILIO_AUTH_TOKEN", $pw_json["TWILIO"]["AUTH_TOKEN"]);
define("TWILIO_FROM_NUMBER", $pw_json["TWILIO"]["FROM_NUMBER"]);
define("TWILIO_TO_NUMBER", $pw_json["TWILIO"]["TO_NUMBER"]);

define("GMAIL_USERNAME", $pw_json["GMAIL"]["USERNAME"]);
define("GMAIL_PASSWORD", $pw_json["GMAIL"]["PASSWORD"]);

$pw_string = null; 
$pw_json = null; 
?>
