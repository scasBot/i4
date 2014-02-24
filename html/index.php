<?php
/*******************************
index.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : Welcome to our website!
***********************************/
require("../includes/config.php"); 

// render explanation can be found in "i4/includes/functions.php"
render("main.php", array("quote" => $filler->random_quote()));
?>
