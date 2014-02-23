<?

/*******************************
api/feedback.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : feedback.php is the api to log all feedback from the web
***********************************/

require("api_config.php"); 

if(!WRITE_AUTH) {
	error("Unauthorized access."); 
}


?>	