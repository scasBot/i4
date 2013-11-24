<?php
/*******************************
manage_user.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : 
Useful for admin (tech, executives) to manage
specific users (reset passwords, change emails etc.,)
***********************************/
require("../includes/config.php"); 
require("../includes/profile_class.php"); 

if(!ADMIN) {
	redirect(ROOT_PUBLIC); 
}

apologize("Sorry, not set up yet."); 
?>