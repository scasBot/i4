<?php

    // configuration
    require("../includes/config.php"); 

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
		// validate submission
        if (empty($_POST['userid']))
        {
            apologize("You must provide your username.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }

        // query database for user
        $rows = query("SELECT * FROM i3_Passwords WHERE `UserId`=?", $_POST["userid"]);
		$user = query("SELECT `UserName` FROM i3_Users WHERE `UserID`=?", $_POST['userid']); 
		
        // if we found user, check password
        if (count($rows) == 1)
        {
            // first (and only) row
            $row = $rows[0];

            // compare hash of user's input against hash that's in database
            if (crypt($_POST["password"], $row["hash"]) == $row["hash"])
            {
                // remember that user's now logged in by storing user's ID in session
                $_SESSION["id"] = $row["UserID"];
				$_SESSION["username"] = $user[0]["UserName"]; 

                // redirect to portfolio
                redirect("../html");
            }
        }

        // else apologize
        apologize("Invalid username and/or password.");
    }
    else
    {
		// get all the users
		$rows = query("SELECT `UserID`, `UserName` FROM `i3_Users` WHERE `hidden`=0 ORDER BY `UserName`"); 
	
        // else render form
        render("login_form.php", array("title" => "Log In", "users" => $rows));
    }

?>
