<?php

    /***********************************************************************
     * functions.php
     *
     * Computer Science 50
     * Problem Set 7
     *
     * Helper functions.
     **********************************************************************/

    require_once("constants.php");

    /**
     * Apologizes to user with message.
     */
    function apologize($message)
    {
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
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = array();

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
			$tmp = array(); 
			$tmp = $handle->errorInfo(); 
			
            // trigger (big, orange) error
            trigger_error($tmp[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

	// converts an array to a string with the function $kv_fun passed in a $key => $value pair 
	// and then adding either the $concat or the $end string to the end of each pair from $arr
	function arr_to_str($kv_fun, $concat, $end, $arr)
	{
		$str = ""; 
		
		$i = 0; 
		$total = count($arr); 
		
		foreach($arr as $key => $val)
		{
			$str .= $kv_fun($key, $val); 
			$str .= ($i == $total - 1 ? $end : $concat); 
			$i++; 
		}
		
		return $str; 
	}
	
	/** 
	* Select items from q_arr with items : "TABLE,", "UPDATE", "WHERE"
	*
	* e.g. $q_arr = ["TABLE" => "db_Clients", "UPDATE" => ["FirstName" => "Tom", "LastName" => "Bobbert"], 
	*					"WHERE" => ["ClientID" => ["=", 1000]]]
	****/
	function query_update($q_arr)
	{
		// UPDATE clause
		$query = "UPDATE " . $q_arr["TABLE"]; 
		
		if(isset($q_arr["UPDATE"]))
		{
			$update_maker = function($k, $v)
			{
				return "`" . $k . "`='" . $v . "'"; 
			}; 

			$query .= "SET " . arr_to_str($update_maker, ", ", " ", $q_arr["UPDATE"]); 
		}
		else
		{
			return false; 
		}
		
		if(isset($q_arr["WHERE"]))
		{
			$where_maker = function($k, $v) 
			{
				return "`" . $k . "`" . $v[0] . "'" . $v[1] . "'"; 
			}; 
			
			$query .= "WHERE " . arr_to_str($where_maker, "AND ", " ", $q_arr["WHERE"]); 
		}			
		else
		{
			return false; 
		}
		
		return query($query); 
	}


	/** 
	* Select items from q_arr with items : "TABLE," "TO_SELECT," "WHERE," AND "ORDER"
	*
	* e.g. $q_arr = ["TABLE" => "db_Clients", "TO_SE$LECT" => ["ClientID", "FirstName", "LastName"], 
	*					"WHERE" => ["FirstName" => ["=", "Willy"]], ["ClientID" => [">", "1000"]]], "ORDER" => ["LastName" => "ASC", "FirstName" => "DESC"]
	****/
	function query_select($q_arr)
	{		
		// SELECT clause
		$query = "SELECT "; 

		if (isset($q_arr["TO_SELECT"]))
		{
			$select_maker = function($k, $v)
			{
				return "`" . $v . "`"; 
			}; 

			$query .= arr_to_str($select_maker, ", ", " ", $q_arr["TO_SELECT"]); 
		}
		else
		{
			$query .= "* "; 
		}
		
		// FROM clause
		$query .= "FROM " . $q_arr["TABLE"] . " "; 
		
		// WHERE clause
		if (isset($q_arr["WHERE"]))
		{
			$where_maker = function($k, $v) 
			{
				return "`" . $k . "`" . $v[0] . "'" . $v[1] . "'"; 
			}; 
			
			$query .= "WHERE " . arr_to_str($where_maker, "AND ", " ", $q_arr["WHERE"]); 
		}
		
		// ORDER BY clause
		if (isset($q_arr["ORDER"]))
		{
			$order_maker = function($k, $v)
			{
				return "`" . $k . "` " . $v; 
			}; 

			$query .= "ORDER BY " . arr_to_str($order_maker, ", ", " ", $q_arr["ORDER"]); 
		}
		
		return query($query); 
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
