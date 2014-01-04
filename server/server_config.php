<?php

ini_set(display_errors, true); 
error_reporting(E_ALL | E_STRICT); 

define("CRON_ROOT", "/nfs/home/groups/scas/web/i4/"); 
require(CRON_ROOT . "includes/constants.php"); 
require(CRON_ROOT . "includes/constants_passwords.php"); 
require(CRON_ROOT . "includes/libraries/ALL.php"); 
require(CRON_ROOT . "includes/functions_database.php"); 
?>
