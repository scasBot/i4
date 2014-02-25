<?php
/*******************************
logout.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : 
Logs out a user
***********************************/
// configuration
require("../includes/config.php"); 

// log out current user, if any
logout();

// redirect user
redirect(ROOT_PUBLIC);
?>
