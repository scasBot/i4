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
	* Returns values as a function fo keys from the database
	*
	**/
	function unique_lookup($table, $key, $key_field, $val_field) {
		$results = query(query_select(array(
			"TABLE" => $table, 
			"WHERE" => array($key_field => 
				array("=", $key)))
		));
		
		// assert2(count($results) == 1, $key_field .": ". $key . " did not return 1 match"); 
		if(empty($results)) {
			return null; 
		}
		
		$result = $results[0]; 
		return $result[$val_field]; 		
	}

	function get_username($user_id) {
		global $filler; 
		
		$result = unique_lookup("i3_Users", $user_id, "UserID", "UserName"); 
		if (is_null($result)) {
			return $filler->random_celeb(); 
		}
		else {
			return $result; 
		}
	}
	
	function get_contacttype($contacttype_id) {
		$result = unique_lookup("db_ContactTypes", $contacttype_id, "ContactTypeID", "Description"); 
		assert2(count($result) == 1, $contacttype_id . " did not match 1 result."); 
		return $result; 
	}
		
	// returns all the contact types as an array with ID => Description
	function get_contact_types() {
		$contact_type_rows = query(query_select(
			array(
				"TABLE" => "db_ContactTypes", 
				"WHERE" => 
					array("Visible" => 
						array(
							"=", 
							1
						)
					), 
				"ORDER" => 
					array("Description" => "ASC"
					)		
			)			
		)); 
		$contact_types = array(); 		
		foreach($contact_type_rows as $row) {
				$contact_types[$row['ContactTypeID']] = $row['Description']; 
		}
		
		return $contact_types; 
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
