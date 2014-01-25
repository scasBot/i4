<?php
	/*
	**	Receives email content via post
	**  and logs it into the database
	**  for "inbox"
	*/

	require("api_includes/api_config.php"); 

	if (WRITE_AUTH)
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$sender = $_POST["sender"];
			$subject = $_POST["subject"];
			$message = $_POST["message"];

			$query = "INSERT INTO db_Emails (sender, subject, message) VALUES ('$sender', '$subject', '$message')";

			$result = query($query);
		}
	}

?>
