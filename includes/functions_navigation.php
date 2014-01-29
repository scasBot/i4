<?php
/*******************************
functions_navigation.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013

Description : 
	functions that help you navigate from
	web page to web page
***********************************/
require_once("constants.php");
require_once("functions_navigation.php");

/**
 * Apologizes to user with message.
 */
function apologize($message) {
	render("apology.php", array("message" => $message));
	exit;
}

/** 
* Benchmarks the time to check latency of website
*/ 
function benchmark($msg = NULL) {
	static $benchmark_counter; 
	if(!isset($benchmark_counter)) {
		$benchmark_counter = 0; 
	} else {
		$benchmark_counter++; 
	}

	static $start; 
	if(!isset($start)) {
		$start = microtime(true); 
	}
	
	echo ("<p>Benchmark " . 
		($msg? $msg : "#" . $benchmark_counter) . ": " . 
		((microtime(true) - $start) * 1000) . "</p>"); 
}

/**
* Prints the string of the i4 specialty
*/
function byi4($feature) {
	return "{" . $feature . "} by scasi4"; 
}

/**
 * Facilitates debugging by dumping contents of variable
 * to browser.
 */
function dump($variable)
{
	require("../templates/dump.php");
	exit;
}

/**
 * Logs out current user, if any.  Based on Example #1 at
 * http://us.php.net/manual/en/function.session-destroy.php.
 */
function logout() {
	$log = new i3_Log($_SESSION["logid"]); 
	$log->logout(); 
	
	// unset any session variables
	$_SESSION = array();

	// expire cookie
	if (!empty($_COOKIE[session_name()])) {
		setcookie(session_name(), "", time() - 42000);
	}

	// destroy session
	session_destroy();
}

/**
 * Returns the data from MYSQL database based on the access
 * from i4/model. Very similar in structure to render, 
 * pass in parameters as values. 
 *
 * Repreents the "model" in MVC
 **/ 
 function model($model, $values = array()) {
	
	if(file_exists("../models/$model")) {
		extract($values); 
		
		require("../models/$model"); 
		return $data; 
	} else {
		trigger_error("Invalid model: $model", E_USER_ERROR);		
	}
 }
	
/**
 * Redirects user to destination, which can be
 * a URL or a relative path on the local host.
 *
 * Because this function outputs an HTTP header, it
 * must be called before caller outputs any HTML.
 */
function redirect($destination)
{
	// handle URL
	if (preg_match("/^https?:\/\//", $destination))
	{
		header("Location: " . $destination);
	}

	// handle absolute path
	else if (preg_match("/^\//", $destination))
	{
		$protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
		$host = $_SERVER["HTTP_HOST"];
		header("Location: $protocol://$host$destination");
	}

	// handle relative path
	else
	{
		// adapted from http://www.php.net/header
		$protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
		$host = $_SERVER["HTTP_HOST"];
		$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		header("Location: $protocol://$host$path/$destination");
	}

	// exit immediately since we're redirecting anyway
	exit;
}

/**
 * Renders template, passing in values.
 */
function render($template, $values = array())
{
	// if template exists, render it
	if (file_exists("../templates/$template"))
	{
		// extract variables into local scope
		extract($values);
		
// EDIT - willy xiao (this needs to be changed to not be here...)
		// include inbox count for header
		$query = "SELECT * FROM db_Emails WHERE isAssigned=0";
		$results = query($query);
		$inboxCount = count($results);

		// render header
		require("../templates/header.php");

		// render template
		require("../templates/$template");

		// render footer
		require("../templates/footer.php");
	}

	// else err
	else
	{
		trigger_error("Invalid template: $template", E_USER_ERROR);
	}
}

function die_with_error($msg) {
	trigger_error($msg . " If you don't know what this means, contact: " . ADMIN_EMAIL . 
		" with the error message."); 
	die(); 
}
?>
