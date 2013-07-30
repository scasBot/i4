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

 /* some functions differ based on LOCAL_HOST or server. If more people start working
		on this project, change LOCAL_HOST to (php_uname("n") != SERVER_NAME), and define SERVER_NAME */
define("LOCAL_HOST_NAME", "WILLYXIAO-THINK"); 
define("LOCAL_HOST", LOCAL_HOST_NAME == php_uname("n")); 

// ROOT_ can be used to create public links or to run scripts
define("ROOT", dirname(dirname((__FILE__)))); 	
define("ROOT_FROM_DOMAIN", (LOCAL_HOST ? "/" : "/~scas/")); 
define("ROOT_PUBLIC", $_SERVER["HTTP_HOST"]. ROOT_FROM_DOMAIN . basename(ROOT)); 

define("AJAX_HASH", "imofftoseethewizardthewonderfulwizardofoz");

define("SCAS_EMAIL", "masmallclaims@gmail.com"); 
define("ADMIN_EMAIL", "wxiao@college.harvard.edu"); 
define("LEGAL_RESEARCH_EMAIL", "SCASlegalresearch@gmail.com"); 

//** MYSQL DATABASE ITEMS **//
define("DATABASE", "scas");
define("PASSWORD", "pantsonfire");
define("SERVER", "mysql.hcs.harvard.edu");
define("USERNAME", "scas");	
?>
