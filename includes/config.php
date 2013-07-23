<?php

    /***********************************************************************
     * config.php
     *
     * SCAS i4
     *
     * Configures pages.
     **********************************************************************/

    // display errors, warnings, and notices
    ini_set("display_errors", true);
    error_reporting(E_ALL);

    // requirements
	require("trolling.php");
    require("constants.php");
    require("functions.php");
	require("libraries/ALL.php"); 
	require("magic_quotes_emulate.php"); 
 
	
    // enable sessions
    session_start();

    // require authentication for most pages
    if (!preg_match("{(?:login|logout|register|ajax|emailed)\.php$}", $_SERVER["PHP_SELF"]))
    {
        if (empty($_SESSION["id"]))
        {
            redirect("login.php");
        }
    }

?>
