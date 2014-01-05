<?php
	/*
	**	Receives email content via post
	**  and logs it into the database
	**  for "inbox"
	*/

	require("../includes/config.php"); 


	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if (isset($_GET["ClientID"]))
		{
			$clientId = $_GET["ClientID"];
		}
		else
		{
			$clientId = -1;
		}

		$id = $_GET["id"];

		$query = "SELECT * FROM db_Emails WHERE id = $id";

		$result = query($query);

		render("assignEmail_form.php", array("title" => "Assign", "mail" => $result, "clientId" => $clientId));
	}
	else
	{
		apologize("Wrong request method");
	}
?>
