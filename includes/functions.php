<?php

    /***********************************************************************
     * functions.php
     *
     * SCASi4
     *
     * Helper functions.
     **********************************************************************/

    require_once("constants.php");

    /**
     * Apologizes to user with message.
     */
    function apologize($message) {
        render("apology.php", array("message" => $message));
        exit;
    }
	
	// assert that all variables inside $var_array isset, if not, apologize
	function assert_isset($var_array) {
		$missing = 0; 
		$apologize = "Following variables are unset : "; 
		
		foreach($var_array as $var_name) {
			if(!isset(${$var_name})){
				$missing++; 
				$apologize .= " " . $var_name; 
			}
		}
		
		$apologize .= ($missing > 1 ? " are unset." : " is unset."); 
		
		if($missing > 0)
			apologize($apologize); 
		else
			return true; 
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
	* Returns a random quote
	*/
	function random_quote($seed_number = NULL) {
		$quotes = array(
			"Freedom lies in being bold - Robert Frost", 
			"Not all who wonder are lost - J.R.R. Tolkein", 
			"Waddup - Willy Xiao", 
			"Everything has beauty but not everyone sees it - Confucius", 
			"Be a yardstick of quality. Some people aren't used to an environment where excellence is expected - Steve Jobs"); 
			
		if(!$seed_number) {
			$seed_number = rand(1, count($quotes)); 
		}
		
		return $quotes[$seed_number - 1]; 
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

?>
