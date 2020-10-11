<?php
/*******************************
constants.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013
***********************************/
 /* some functions differ based on LOCAL_HOST or server. */
define("SERVER_NAME", "masmallclaims.org"); 
define("LOCAL_HOST",  strstr(php_uname("n"), SERVER_NAME) === false);

// ROOT_ can be used to create public links or to run scripts
define("ROOT", dirname(dirname((__FILE__)))); 	
if (LOCAL_HOST) {
	define("ROOT_FROM_DOMAIN", (LOCAL_HOST ? "/" : "/~masmallc/")); 
	define("ROOT_PUBLIC", "http://" . $_SERVER["HTTP_HOST"]. ROOT_FROM_DOMAIN . basename(ROOT)); 
} else {
	define("ROOT_PUBLIC", "http://i4.masmallclaims.org"); 
}

define("LEADERBOARD_STATS_FILE", ROOT . "/data/" . "data_leaderboard.php"); 

define("SCAS_EMAIL", "masmallclaims@gmail.com"); 
define("ADMIN_EMAIL", "omidiran@college.harvard.edu"); 
define("LEGAL_RESEARCH_EMAIL", "masmallclaims@gmail.com"); 

// idling on website for over 30 minutes is a log-out
define("IDLE_TIME_LIMIT", 3600);

define("PASSWORDS_FILE", ROOT . "/server/hash.json"); 


?>
